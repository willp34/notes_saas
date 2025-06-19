<?php

namespace App\Services ;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class AuthService{
	
	public function user(){
		
		
		//print_r($_SERVER);
		$header = $_SERVER['HTTP_AUTHORIZATION']  ?? ''  ;
		
		if(!preg_match('/Bearer\s+(.*)$/i',$header,$matches)) return "Acccess denied";
		
		$token = $matches[1];
		
		try{
			$decoded = JWT::decode($token,new Key(getenv('JWT_SECRET'),'HS256'));
			return (new UserModel())->find($decoded->sub);
		}
		catch(\Exception $e)
		{
			return $e;
		}

		
		
	}
}