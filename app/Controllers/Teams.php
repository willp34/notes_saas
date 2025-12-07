<?php 


namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
//use App\Models\UserModel;


use App\Models\TeamModel;
use App\Models\TeamUserModel;
use App\Models\UserModel; 

class Teams extends BaseController
{
	
	private $data = null;
	protected $user ;
	protected $teamModel ;
	protected $teamuserModel;
	
	protected $userModel;
	
	
	public function __construct(){
		$this->data['modules']= array(  "src/Ajax_form.js"  ) ; 
		$this->data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js");
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
		
		$this->data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js","text_stats.js");
		$this->data["css"] = array("Notepad.css");
        $this->data['modal_Header'] = "Invite to Team";
		$this->data['modal_Form'] = view('forms/team_invite',array());
		$this->data['memberTeams'] = $memberTeams;
		$this->data["teamsBelongTo"] = $createdTeams;

		$this->template('teams',$this->data);
    }
	
	public function logon(){
//		$this->data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js");
		$this->this->template('login',$data);
	}
	public function test(){
		
		echo "test";
	}
}