<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Authentication\Authentication;
// custom Models
use App\Models\UserModel;
use  App\Services\AuthService;
use OTPHP\TOTP;




class Security extends ResourceController
{
	protected $userModel;
	
	
	public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
       
    }
    public function index()
    {
        //
    }
	
	// the SetUp
	public function enable2FA(){
		
		//get authorized user
	
		$user =   $user = $this->request->user ?? null;;
        if (!$user) {
            return $this->failUnauthorized('Unauthenticated');
        }

        $userId = $user['id'];
        $userEmail = $user['email'];
		
		$totp = TOTP::create();
		$totp->setLabel($userEmail);
		$totp->setIssuer('NoteSass');
		$secret = $totp->getSecret();
		
		// Save secret bur do not enable yet
		
		$this->userModel->update($userId,[
			'two_factor_enabled' => 0,
			'two_factor_secret' => $secret
		]);	
		
		// Generate QR Code for authorisation App
		

		
		return $this->respond([
			'qr_url' => $totp->getProvisioningUri() ,
			'secret' => $secret
		]);

	}
	
	public function confirm2FA()
	{
		  $user = $this->request->user ?? null;
		if (!$user) {
            return $this->failUnauthorized('Unauthenticated');
        }

        $userId = $user['id'] ;

		$code = $this->request->getJSON()->code ?? null;

		if (! $code) {
			return $this->fail('Code is required', 400);
		}

		$user2fa = $this->userModel->find($userId);
		
		if (empty($user2fa['two_factor_secret'])) {
            return $this->fail('2FA not initialized', 400);
        }

		$totp = TOTP::create($user2fa['two_factor_secret']);

		if (! $totp->verify((string) $code, null, 1)) {
			return $this->fail('Invalid authentication code', 401);
		}

		$this->userModel->update($userId, [
			'two_factor_enabled' => 1
		]);

		return $this->respond([
			'message' => '2FA enabled successfully'
		]);
	}
	
	public function disable2FA(){
		
		//get authorized user
		$user = $this->auth->user();
        if (!$user) {
            return $this->failUnauthorized('Unauthenticated');
        }

		$userId = is_array($user) ? $user['id'] : $user->id;
		
		$this->userModel->update($userId,[
			'two_factor_enabled' => 0,
			'two_factor_secret' => null
		]);	
		
		return $this->respond([ 'message'	=> '2FA disabled'	]);
	}
	
	
}
