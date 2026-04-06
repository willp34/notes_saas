<?php
namespace  App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
	private $data = null;
	protected $services ;
	
	
	public function __construct(){
		$this->services = new ServiceModel();
		$this->data['js'] = array("jquery/jquery.min.js","jquery/jquery.cookie.js","shopping.js"	);
	}
	
	public function index(){
		
		$services = $this->services->getProduct_and_Services();
		
		$this->data["products"]= $services;
		$this->template("service",$this->data);
	}
}