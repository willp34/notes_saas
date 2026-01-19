<?php

namespace App\Services ;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class AuthService{
	
	public function user(): ?array 
	{
		
		
		//print_r($_SERVER);
		//$header = $_SERVER['HTTP_AUTHORIZATION']  ?? ''  ;
		$request = service('request');
        $header  = $request->getHeaderLine('Authorization');
		
		if(!preg_match('/Bearer\s+(.*)$/i',$header,$matches)) return "Acccess denied";
		
		$token = $matches[1];
		
		if (! preg_match('/Bearer\s+(.+)$/i', $header, $matches)) {
            return null;
        }
		
		$token = $matches[1];

        try {
            $decoded = JWT::decode(
                $token,
                new Key(getenv('JWT_SECRET'), 'HS256')
            );
			return (new UserModel())->find($decoded->sub) ?: null;
		}
		catch(\\Throwable $e)
		{
			return null ;
		}

		
		
	}
}