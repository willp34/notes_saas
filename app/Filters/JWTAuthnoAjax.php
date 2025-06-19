<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JwtAuthNoAjax implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = $_COOKIE['CI4J~WT'] ?? null;
        if (!$token) {
				
					$current_uri = current_url().'/'.$_SERVER['QUERY_STRING'];
					setcookie('CI4-redirect_uri', $current_uri, [
					'expires' => time() + 600,
					'httponly' => true,
					'path' => '/',
					'secure' => false, // Set true in production
					'samesite' => 'Lax'
				]);
            return redirect()->to('/home/login');
        }

        try {
            $key = getenv('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // Attach user info to request or global context if needed
			
			 $request->user = [
                'id'    => $decoded->uid,
                'email' => $decoded->email,
            ]; 
			return $request;
        } catch (\Exception $e) {
            return redirect()->to('/home/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

?>