<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
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
            return $this->fail('Email and password are required.',422);
        }

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->fail('Invalid credentials.',401);
        }
		
		// JWT payload
        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600; // Token expires in 1 hour

        $payload = [
            'iss' => base_url(),
            'aud' => base_url(),
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $user['id'],
            'email' => $user['email']
        ];

        $token = JWT::encode($payload, $key, 'HS256');
		
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
		
	public function logOut(){
			
			setcookie('token', '', time() - 3600, '/');
			setcookie('CI4J~WT', '', time() - 3600, '/');
			return redirect()->to('/home/login');
		}

	public  function sendResetLink(){
			$resetInformation = array();
			$data = $this->request->getJSON(true);
			//$data = $this->request->getPost();
			
			$emailAddress = $data['email'] ?? null;
			
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