<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Authentication\Authentication;

use App\Models\UserModel;
use App\Models\DeviceModel;   
use App\Models\LoginVerifyModel; 

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use  App\Services\EmailService;
use  Config\Services;
class Auth extends ResourceController
{
	protected $userModel;
	protected $deviceModel ;
	protected $loginVerifyModel;
	
	public function __construct(){
		$this->userModel = new UserModel();
		$this->deviceModel = new DeviceModel();
		$this->loginVerifyModel = new loginVerifyModel();
		
		}
	public function login(){
		
		
		$data = $this->request->getJSON(true);
		
		$email = $data['email'] ?? null;
        $password = $data['pswd'] ?? null;

        if (!$email || !$password) {
            return $this->failValidationErrors('Email and password are required.');
        }
		

        $user = $this->userModel->where('email', $email)->first();
		
		if(!$user ){
			 return $this->respond([
				'error' => 'Invalid credentials. No such user'
			]);
		}

		// check if account is locked

		if($user['lock_until']  && strtotime($user['lock_until']) > time() ){
			 return $this->respond([
				'error' => 'Account locked until '. $user['lock_until']
			]);
		}
		// wrong password 
        if ( !password_verify($password, $user['password'])) {
			
			$attempts = $user['failed_attempts']+1;
			
			$locked_until = null;
			
			//Progressive lock calculation 
			
			$lockTime = match(true){
				$attempts >= 12 => '+7 days ',
				$attempts  >= 9 => '+24 hours',
				$attempts >=6 => '+1 hour',
				$attempts >=3 => '+15 minutes',
				default => null,
			};
			
			//feature update
			$this->userModel->update($user['id'],[
				'failed_attempts' => $attempts,
				'lock_until' => $lockTime ?  date('Y-m-d H:i:s', strtotime($lockTime)) : null,
			]);
            return $this->respond([
				'error' => 'Invalid credentials.'
			]);
        }
		
		
		// Successful log in -> reset counters
		
		$this->userModel->update($user['id'],[
				'failed_attempts' => 0,
				'lock_until' => null,
			]);
		
		// After pasword is verified 
		
		$ip = $this->request->getIPAddress();
		$agent = $this->request->getUserAgent()->getAgentString();
		
		$deviceHash = hash('sha256', $ip . $agent) ;
		
		// Check if device is already trusted
		
		$device = $this->deviceModel
			->where('user_id',$user["id"])
			->where('device_hash',$deviceHash)
			->first();
			
		if(!$device || !$device["verified"]){
			
			// gernerate verification token
			
			$token = bin2hex(random_bytes(32));
			$expires =  date('Y-m-d H:i:s', strtotime('+10 minutes'));
			
			// store verification request
			$this->loginVerifyModel->insert([
					'user_id'    => $user['id'],
					'token'      => $token,
					'expires_at' => $expires,
					'ip'         => $ip,
					'user_agent' => $agent
				]);
				
			// Send confirmation email
			$this->sendNewDeviceEmail($user['email'], $token, $ip, $agent);
			// ⛔ STOP login until verified
			return $this->failUnauthorized(
				'New device detected. Check your email to confirm this login.'
			);
		}
		
		
		// Generate JWT
		$token = $this->generateJWT($user);
		
		setcookie('CI4J~WT', $token, [
            'expires' => time() + 3600,
          //  'httponly' => true,
            'path' => '/',
            'secure' => false, // Set true in production
            'samesite' => 'Lax'
        ]);
		
		$jwtInformation["token"] =$token;
		$jwtInformation["user"]= $user; 
		
		
		$redirect_uri = $_COOKIE['CI4-redirect_uri'] ?? null;

		setcookie('CI4-redirect_uri', '', time() - 600, '/');
		//return  $this->respond($jwtInformation);
		// Safely handle redirect
			
				// Fallback if no redirect URI set
				return $this->respond([
					'token' => $token,
					'user'  => $user,
					'redirect' => $redirect_uri
					
				]);
		}
		
	private function sendNewDeviceEmail($email, $token, $ip, $agent){
		
		$link = base_url("auth/verify-login/$token");
		$message = view('emails/new_device', [
			'link'  => $link,
			'ip'    => $ip,
			'agent' => $agent,
			'name' => 'William Pritchard'
		]);

	

			
		//$emailService = \Config\Services::email();
		$emailService = Services::email();
		$emailService->setTo($email);
		$emailService->setSubject('New Login Attempt — Was This You?');
		$emailService->setMessage($message);
		$emailService->setMailType('html'); // Set to 'text' if you don’t want HTML
		$emailService->send();
		if (!$emailService->send()) {
			return $this->response->setJSON([
				'error' => 'Email failed',
				'debug' => $emailService->printDebugger(['headers'])
			])->setStatusCode(500);	
		}
	}
	
	private function generateJWT($Authorized_user){
		// JWT payload
        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600; // Token expires in 1 hour

        $payload = [
            'iss' => base_url(),
            'aud' => base_url(),
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $Authorized_user['id'],
            'email' => $Authorized_user['email']
        ];

        return JWT::encode($payload, $key, 'HS256');
		
	}
	public function logOut(){
			
			setcookie('token', '', time() - 3600, '/');
			setcookie('CI4J~WT', '', time() - 3600, '/');
			return redirect()->to('/home/login');
		}

	public  function sendResetLink(){
			$resetInformation = array();
			$data = $this->request->getJSON(true);
			//$data = $this->request->getPost();
			
			$emailAddress = trim($data['email'] );
			
			

			if (!$emailAddress) {
	
				return $this->respond([
					'error' => 'Email is required.'
				]);
				return $this->failValidationErrors('Email is required.');
			}
			$user =  $this->userModel->where('email', $emailAddress)->first();
			if (!$user) {
					return redirect()->back()->with('error', 'Email not found.');
			}
		
			$token = bin2hex(random_bytes(50));
			$expires = date("Y-m-d H:i:s ", time()+3600) ; // hour from now
			$this->userModel->update($user["id"] ,[
					'reset_token' => $token,
					'reset_expires_at' => $expires
			 ]);
			 
			 $message = new EmailService($emailAddress, $token);
			 $resetLink = base_url("index.php/home/resetPassword/$token");
			 $html = view('emails/resetPasswordLink', ['resetLink' => $resetLink, 'name' =>"William"]);
			 $message->send($html);
			 /* Add this inside your sendResetLink() method
					$email = \Config\Services::email();

					$email->setTo($emailAddress);
					$email->setSubject('Password Reset Request');

					$resetLink = base_url("auth/resetPassword/$token");
					$message = "Hello william,<br><br>"
							 . "You requested a password reset. Click the link below to reset your password:<br><br>"
							 . "<a href='$resetLink'>$resetLink</a><br><br>"
							 . "If you didn’t request this, you can ignore this email.";

					$email->setMessage($message);
					$email->setMailType('html'); // Set to 'text' if you don’t want HTML

					if ($email->send()) { } else {
						// Debug error
						$resetInformation["error"] = $email->printDebugger(['headers']);
					}
			/////////////////////////////////////////
			*/
			$resetLink = base_url("auth/resetPassword/$token");
			$resetInformation["reset_link"] = $resetLink;
			$resetInformation["message"] = "try      $expires   user id  ".$user["id"];
			//$resetInformation["user"] = $this->userModel->where('email', $email)->first();
			return  $this->respond($resetInformation);
	}
}
?>