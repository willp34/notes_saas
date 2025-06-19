<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = "users";
	protected $primaryKey= 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['email','password', 'reset_token', 'reset_expires_at'];
	protected $useTimestamps = true;
	
	
	
	 // Get teams user belongs to
    public function getTeams($userId)
    {
        return (new TeamUserModel())
            ->select('teams.*')
            ->join('teams', 'teams.id = team_users.team_id')
            ->where('team_users.user_id', $userId)
            ->findAll();
    }
	
	// Check if user belongs to a team
	public function belongsToTeam($userId,$teamId){
		
		return (new TeamUserModel())->belongsToTeam($teamId, $userId);
	}
	// Check if user is admin in a team
	public function isTeamAdmin($userId, $teamId){
		
		  return (new TeamUserModel())->isUserAdmin($teamId, $userId);
	}
	
	public function getAllUsers(){
		
		$records =$this->select(' id')->findAll();
		return array_column($records,'id');	  
	}
	
	public function getUsersforSelect($term="will"){
		
		$records = $this->select('id, email')
                ->like('email', $term)
                ->findAll();
		return $records;	
	} 
	
	public function getUsersNotInTeam($teamId, $term = 'will') {
    $db = \Config\Database::connect();
    $builder = $db->table('users');

     $builder->select('users.id, users.email')
        ->like('users.email', $term)
        ->where("users.id NOT IN (
            SELECT user_id FROM team_users WHERE team_id = " . (int)$teamId . "
        )");


    return $builder->get()->getResult();
}
}