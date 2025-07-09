<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{
    public function index()
    {
		echo ENVIRONMENT;	
		$data['js']= array("jquery/jquery.min.js","src/Process_request.js","Validate_registrationform.js"  ) ; 
        $this->template('home',$data);
    }
	
	public function logon(){
		$data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js","logonForm.js");
		$this->template('login',$data);
	}
	public function test(){
		
		echo "test";
	}
	
	public function forgotPassword(){
			$data["content"] = "hi";
			$data['js'] = array("jquery/jquery.min.js","src/Process_request.js","ResetLink.js");
			return $this->template('auth/forgot_password',$data);
			
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
	
	$data["token"] = $token ;
	
	
	
	
	
		return $this->template('auth/reset_password',$data);
	}
	
}
