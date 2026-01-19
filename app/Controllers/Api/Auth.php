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
			 return $this->failUnauthorized('Invalid credentials.');
		}

		// check if account is locked

		if($user['lock_until']  && strtotime($user['lock_until']) > time() ){
			 return $this->failUnauthorized('Account locked until '. $user['lock_until']);
		}
		// wrong password 
        if ( !password_verify($password, $user['password'])) {
			
			//Call failied logon function
			
			$this->handleFailedLogin($user);
			
            return $this->failUnauthorized('Invalid credentials.');
        }
		
		
		// Successful log in -> reset counters
		
		$this->userModel->update($user['id'],[
				'failed_attempts' => 0,
				'lock_until' => null,
			]);
		
		// After pasword is verified 
		// Device verification 
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
			// call function handleNewDevice
			return $this->handleNewDevice($user, $ip, $agent);			
		}
		
		// 2FA impremented here is enabled
		
		if($user['two_factor_enabled']){
			
			
			// call function send2FA
			return $this->send2FA($user);
			
		}
		
		// call function complete logon
		return $this->completeLogin($user);
		
		}
	private function send2FACode($email, $code){
		
		$emailService = Services::email();
		$emailService->setTo($email);
		$emailService->setSubject("Your login Verification Code");
		$emailService->setMessage(" Your Code: $code (expires in 5 minutes)");
		$emailService->setMailType('html'); // Set to 'text' if you don’t want HTML
		$emailService->setReplyTo('support@yourdomain.com', 'Notes SaaS Support');
		$emailService->send();
	}	
	private function sendNewDeviceEmail($email, $token, $ip, $agent){
		
		$link = base_url("auth/verifyLogin/$token");
		$message = view('emails/new_device', [
			'link'  => $link,
			'ip'    => $ip,
			'agent' => $agent,
			'name' => 'William Pritchard'
		]);

	

			
		//$emailService = \Config\Services::email();
		$emailService = Services::email();
		$emailService->setTo($email);
		$emailService->setSubject('New Login Attempt — Was This You');
		$emailService->setMessage($message);
		$emailService->setMailType('html'); // Set to 'text' if you don’t want HTML
		$emailService->setReplyTo('support@yourdomain.com', 'Notes SaaS Support');
		$emailService->send();
		
		/*if (!$emailService->send()) {
			return $this->response->setJSON([
				'error' => 'Email failed',
				'debug' => $emailService->printDebugger(['headers'])
			])->setStatusCode(500);	
		}*/
	}
	
	// verify 2FA endpoint
	
	/*public function verify2FRA(){
		
		$data = $this->request->getJSON(true);
		//valid for 5 minutes
		$cache = cache()-save("2fa_{$user['id']}" );
		
		if(!$cache || $cache["expires"] < time()){
			return  $this->failUnauthorized("Code expires.");
		}		
		
		if($data['code'] != $cache['code']){
			return $thiks->failUnauthorized('Invalid Code.');
		}
		cache()->delete("2fa_{$user['id']}" );
		
		$user = $this->userModel->find($data['user_id']);
		$token = $this->generateJWT($user);
		
		return $this->respond(['token' => $token]);
	}*/
	public function verify2FA(){
		
		$userId = $this->request->getPost("user_id");
		$code = $this->request->getPost("code");
		$user = $this->userModel->find($userId);
		
		if( !$user || $user["two_factor_enabled"] ||!$user["two_factor_secret"]){
				return $this->failUnauthorized('Invalid user');
		}
		
		$totp = TOTP::create($user->two_factor_secret);
		
		
		if(!$totp->verify($code)){
				
				return $this->fail("Invalid or expired code", 401);
		}
		
		return $this->completeLogin($user);
	
	}
	
	
	
	// verify new device
	public function verifyLogin($token){
			$record = $this->loginVerifyModel
				->where('token',$token)
				->where('expires_at >=',date('Y-m-d H:i:s'))
				->first();
				
				if(!$record){
					return "Invalid or expired verification link.";
				}
				
				$deviceHash = hash('sha256',$record['ip'].$record['user_agent']);
				
				$this->deviceModel->insert([
					'user_id' => $record['user_id'],
					'device_hash' => $deviceHash,
					'verified' => 1,
					'last_seen' => date('Y-m-d H:i:s')
				]);
				
				$this->loginVerifyModel->delete($record["id"]);
				
				return 'login verified. You may now sign in';
	}
	
	
	private function handleFailedLogin($user){
		$attempts = $user['failed_attempts']+1;
			
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
	}
	private function handleNewDevice($user, $ip,$agent){
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
	
	// send 2 factor authentication
	private function send2FA($user){
			$otp = random_int(100000, 999999);
			$expires = time() +30 ; // after 5 minutes
			
			cache()-save("2fa_{$user['id']}"  ,[
				'code'  => $otp,
				'expires' => $expires

				], 300 );
				//Send email
				$this->send2FACode($user["email"], $otp);
				//response
				return $this->respond([
					'requires_2fa' => true,
					'user_id' => $user['id']
				]);
	}
	// function  complete Login
	private function completeLogin($user){
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
	
		// Safely handle redirect
			
				// Fallback if no redirect URI set
				return $this->respond([
					'status' => "Success",
					'token' => $token,
					'user'  => $user,
					'redirect' => $redirect_uri
					
				]);
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