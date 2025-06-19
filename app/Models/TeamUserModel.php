<?php 

namespace App\Models;

use CodeIgniter\Model;

class TeamUserModel extends Model
{
	protected $table = "team_users";
	protected $primaryKey= 'id';
	protected $allowedFields = ['team_id','user_id','role'];
	protected $returnType = 'array';
	protected $useTimestamps = false;
	
	public function isUserAdmin($teamId,$userId){
		
		return $this->where([
			'team_id' => $teamId,
			'user_id' => $userId,
			'role' =>'admin'
		])->first() !=null;
	}
	
	public function belongsToTeam($teamId,$userId){
		
		return $this->where([
			'team_id' => $teamId,
			'user_id' => $userId
		])->first() !=null;
	}
	
	public function getUserRole($teamId,$userId){
		
		$record = $this->where(['team_id' => $teamId ,'user_id' => $userId])->first();
		return $record['role'] ?? null;
	}
	
	public function getTeamsByUser($userId, $type = 'created') {
			
			switch($type){
				case "created":
					return $this->select('tm.id, tm.name as team_name, 
							(SELECT COUNT(*) FROM team_users WHERE team_users.team_id = tm.id) AS number_of_members')
						->from('teams as tm', true)
						->where('tm.created_by', $userId)
						->findAll();
					break;
				case "member":
						return $this->select('tm.id, tu.role as role, tm.name as team_name')
					->from('teams as tm', true)
					->join('team_users tu', 'tu.team_id = tm.id')
					->where('tu.user_id', $userId)
					->findAll();
					break;
			    default:
					throw new \InvalidArgumentException("Invalid team query type: '$type'. Expected 'created' or 'member'.");
				}

    // Optional: throw exception or return empty if invalid type
    return [];
}
	
	public function usersInMyTeam($teamId){
		
		$records =$this->select('team_users.team_id, users.email as user_email')
                ->join('users', 'users.id = team_users.user_id')
                ->where('team_users.team_id', $teamId)
                ->findAll();
		return $records;
	}
}