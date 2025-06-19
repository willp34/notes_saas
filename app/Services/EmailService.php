<?php

namespace App\Services ;


class EmailService{
	
	private $emailAddress; 
	private $token;
	
	public function __construct($mail,$secureToken){
		
		$this->emailAddress =$mail;
		$this->token= $secureToken ;
	}
	
	public function send($template){
		
				$e_token = $this->token;
				$email = \Config\Services::email();

				$email->setTo($this->emailAddress);
				$email->setSubject('Password Reset Request');

				$resetLink = base_url("auth/resetPassword/$e_token");
			
				$message = $template;
				$email->setMessage($message);
				$email->setMailType('html'); // Set to 'text' if you don’t want HTML

				if ($email->send()) {
						return "Message Sent";
					} else {
					// Debug error
					return $email->printDebugger(['headers']);
				}
	}
}