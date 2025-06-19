<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JWTAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
		//echo "output".$authHeader
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return Services::response()->setJSON(['message' => 'Token required'])->setStatusCode(401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            // Optionally store $decoded in the request for later use
			 $request->user = [
                'id'    => $decoded->uid,
                'email' => $decoded->email,
            ]; 
			
			
			return $request;
        } catch (\Exception $e) {
            return Services::response()->setJSON(['message' => 'Invalid token '.$authHeader ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}


?>