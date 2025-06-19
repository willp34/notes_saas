<?php

namespace  App\Controllers\Api;


use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Authentication\Authentication;
use App\Models\TeamModel;
use App\Models\TeamUserModel;
use App\Models\UserModel; 

class Team extends ResourceController
{
	protected $user ;
	protected $teamModel ;
	protected $teamuserModel;
	
	protected $userModel;
	
	public function __construct(){
		
		$this->teamModel = new TeamModel();
		$this->teamuserModel = new TeamUserModel();
		$this->userModel = new UserModel();
		$this->user = new UserModel();
	}
	
	public function index()
    {
		
		
		
		$this->user = $this->request->user;
		
		
		 
		
		 return $this->respond([
            'message' => 'Dashboard data loaded.',
            'userEmail' => $this->user["email"] ?? null,
			'userID' => $this->user["id"] ?? null,
			
			]);
        
    }
	
	public function create(){
		
		$formData =$this->request->getJSON(true);
		$this->user = $this->request->user;
		$data["user"]  = $this->user;
		$data["input"] = $formData;

		$teamID = $this->teamModel->insert([
				"name" => $formData["team_name"],
				"created_by" => $this->user["id"]
		]);
		
		$this->teamuserModel->insert([
				"team_id" => $teamID,
				"user_id" => $this->user["id"], 
				"role" => "admin"
		]);
		$data["team_id"]= $teamID;
		return $this->respond($data);
		
	}
	
	public function invite($teamID){
		$this->user = $this->request->user;
	
		
		
		if( !$this->userModel->isTeamAdmin($this->user["id"], $teamID) ){
			return $this->failForbidden('Only admins can invite');
		}
		$inviteUserInfo = $this->request->getJSON(true);
		
		foreach($inviteUserInfo["users[]"] as $invitee){
			
			echo "Invite $invitee   ";
			$invitee = (new UserModel())->where("id",$invitee)->first();
			
			if(!$invitee) return $this->failNotFound('User not found');
			/*$this->teamuserModel->insert([
					"team_id" => $teamID,
					"user_id" => $invitee["id"], 
					"role" => $inviteUserInfo['role'] ?? 'member'
			]);
			*/
		
		
		
		}
		
		$data["message"]= "User invited";
		return $this->respond($data);
	}
	
	public function getUsersforTeam($teamId){
	       $usersOfTeam = $this->teamuserModel->usersInMyTeam($teamId); 
		   if(!$usersOfTeam) return $this->failNotFound('User not found');
		   
		   $data["users_in_Team"]= $usersOfTeam;
		return $this->respond($data);
		   
	}
	
}