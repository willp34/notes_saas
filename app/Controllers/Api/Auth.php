<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Authentication\Authentication;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use  App\Services\EmailService;

class Auth extends ResourceController
{
	protected $userModel;
	
	public function __construct(){
		$this->userModel = new UserModel();
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
			if($attempts>=3){
				$locked_until = date('Y-m-d H:i:s', strtotime('+15 minutes'));
			}
			
			//feature update
			$this->userModel->update($user['id'],[
				'failed_attempts' => $attempts,
				'lock_until' => $locked_until,
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