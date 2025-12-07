<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{
	private $data = null;
	public function  __construct()
	{
		$this->data['modules']= array( "src/FormValidator.js " ,"src/registerForm.js" ,"src/Ajax_service.js","src/Ajax_form.js" ) ; 
        $this->data['js'] = array("jquery/jquery.min.js" ,"jquery/jquery.cookie.js");
	}
    public function index()
    {
		echo ENVIRONMENT;	
		$this->data['js']= array("jquery/jquery.min.js", "jquery/jquery.cookie.js" ) ; 
        $this->template('home',$this->data);
    }
	
	public function logon(){
		//$this->data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js");
		$this->template('login',$this->data);
	}
	public function test(){
		
		echo "test";
	}
	
	public function forgotPassword(){
			$this->data["content"] = "hi";
			
			return $this->template('auth/forgot_password',$this->data);
			
		}
		
	public function resetPassword($token)
	{
		
		 $userModel = new UserModel();
		 $user = $userModel->where('reset_token', $token)
						  ->where('reset_expires_at >=', date('Y-m-d H:i:s'))
						  ->first();

		if (!$user) {
			return redirect()->to('/home/login')->with('error', 'Invalid or expired token.');
		}
		
		$this->data["token"] = $token ;
		
		return $this->template('auth/reset_password',$this->data);
	}
	
}
