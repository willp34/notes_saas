<?php 


namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
//use App\Models\UserModel;


use App\Models\TeamModel;
use App\Models\TeamUserModel;
use App\Models\UserModel; 

class Teams extends BaseController
{
	
	protected $user ;
	protected $teamModel ;
	protected $teamuserModel;
	
	protected $userModel;
	
	public function __construct(){
		
		$this->teamModel = new TeamModel();
		$this->teamuserModel = new TeamUserModel();
		$this->userModel = new UserModel();
	}
    public function index()
    {
		echo ENVIRONMENT;
		$this->user =$this->request->user;
	
		
	
		
		$createdTeams = $this->teamuserModel->getTeamsByUser($this->user['id'], 'created');
		$memberTeams = $this->teamuserModel->getTeamsByUser($this->user['id'], 'member');
		
		$data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js", "src/Process_request.js","Auth.js");
        $data['modal_Header'] = "Invite to Team";
		$data['modal_Form'] = view('forms/team_invite',array());
		$data['memberTeams'] = $memberTeams;
		$data["teamsBelongTo"] = $createdTeams;
		$this->template('teams',$data);
    }
	
	public function logon(){
		$data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js","logonForm.js");
		$this->template('login',$data);
	}
	public function test(){
		
		echo "test";
	}
}