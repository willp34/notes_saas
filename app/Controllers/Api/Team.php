<?php

namespace  App\Controllers\Api;


use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Authentication\Authentication;

use App\Models\TeamModel;
use App\Models\TeamUserModel;
use App\Models\UserModel; 

use App\Models\TeamInvitesModel    ;

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
		
		$data = $this->request->getJSON(true);

		if (!$data || !isset($data['team_name'])) {
			return $this->failValidationError('team_name is required.');
		}

		$team_name = trim($data['team_name']);

		// Extra safety: reject empty string after trimming
		if ($team_name === '') {
			return $this->response->setJSON([
				'error' => 'Please enter a team name.'
			]);
			// return $this->failValidationError('Team name cannot be empty.');
		}
		
		$user = $this->request->user;

		$teamID = $this->teamModel->insert([
				"name" => $team_name,
				"created_by" => $user["id"]
		]);
		
		$this->teamuserModel->insert([
				"team_id" => $teamID,
				"user_id" => $user["id"], 
				"role" => "admin"
		]);
		
		$data["team_id"]= $teamID;
		$data["message"] = "team created successfully" ;
		return $this->respondCreatd($data);
		
	}
	
	public function invite($teamID){
		$this->user = $this->request->user;
	
		
		
		if( !$this->userModel->isTeamAdmin($this->user["id"], $teamID) ){
			return $this->failForbidden('Only admins can invite');
		}
		
		
		
		$inviteUserInfo = $this->request->getJSON(true);
		
		foreach($inviteUserInfo["users[]"] as $invitee){
			
			//echo "Invite $invitee   ";
			
			$inviteModel = new TeamInvitesModel();
			
			$invitee = (new UserModel())->where("id",$invitee)->first();
			
			if(!$invitee) return $this->failNotFound('User not found');
			
			
			$token = $inviteModel->creatInvite($teamID,$invitee['email'])   ;
			$lik = site_url("teams/acceptInvite/$token");
			
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
	
	
	public function acceptInvite($token)
	{
		$authUser =  $this->request->user;

		$inviteModel = new TeamInviteModel();
		$invite = $inviteModel->getValidInvite($token);
		if (!$invite) {
			return $this->failNotFound('Invalid or expired invite.');
		}

		// Add to team
		$teamUserModel = new TeamUserModel();
		$teamUserModel->insert([
			'team_id' => $invite['team_id'],
			'user_id' => $authUser['id'],
			'role' => 'member'
		]);

		// Mark invite used
		$inviteModel->update($invite['id'], ['status' => 'accepted']);

		return $this->respond(['message' => 'You have joined the team.']);
	}
	
	public function getUsersforTeam($teamId){
	       $usersOfTeam = $this->teamuserModel->usersInMyTeam($teamId); 
		   if(!$usersOfTeam) return $this->failNotFound('User not found');
		   
		   $data["users_in_Team"]= $usersOfTeam;
		return $this->respond($data);
		   
	}
	
}