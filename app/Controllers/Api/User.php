<?php  

 namespace  App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class User extends ResourceController
{
	use ResponseTrait; 
	protected $newUser ;
	
	
	public function __construct(){
		$this->newUser = new UserModel();
	}
	public function create(){
		
		
		$data = $this->request->getJSON(true);
		$password = password_hash($data['pswd'], PASSWORD_DEFAULT);
		
		try{
			$userId = $this->newUser->insert([
			'email' => $data['email'],
			'password' => $password
		] ); 
		//$data = json_decode(file_get_contents('php://input'), true);
		
			return $this->respondCreated(['user_id' => $userId]);
		}
		catch (\Exception $e)
		{
			return $this->failServerError($e->getMessage());
		}
		
		
	}
	
	public function getUsers($teamID,$term){
		$data = $this->request->getJSON(true);
		
		$userInfo = $this->newUser->getUsersNotInTeam($teamID,$term);
		
		return $this->respondCreated(['items' => $userInfo]);
		
	}
}