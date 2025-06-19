<?php 

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
	protected $table = "teams";
	protected $primaryKey= 'id';
	protected $allowedFields = ['name','created_by'];
	protected $returnType = 'array';
	protected $useTimestamps = false;
	
	
	
	public function getAllteams(){
		 
		$records =$this->select('id')->findAll();
		return array_column($records,'id');	
		
	}
}