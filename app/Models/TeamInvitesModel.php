<?php 

namespace App\Models;

use CodeIgniter\Model;

class TeamInvitesModel extends Model
{
	protected $table = "team_invites";
	protected $primaryKey= 'id';
	protected $allowedFields = ['team_id','email','token','status'];
	protected $returnType = 'array';
	protected $useTimestamps = false;
	
	public function creatInvite($teamId,$email){
		
		$token  = bin2hex(random_bytes(32));
		$this->insert([
			'team_id' => $teamId,
            'email' => $email,
            'token' => $token,
            'status' => 'pending',
		]);
		
		return $token;
	}
	
	public function getValidInvite($token){
		
		return $this->where(['token' => $token, 'status' => 'pending'])->first();
	}
}