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
	/**
     * Delete all teams with empty, null, or whitespace-only names.
     *
     * @return int Number of deleted rows
     */
    public function deleteEmptyNames()
    {
		// first find ID columns  
		
		$ids = $this->select('id')
				->where('name','')
				->orWhere('name',null)
				->orWhere('TRIM(name) = \'\'', null, false)
				->findColumn('id');
				
		if(empty($this)){
			return 0;
		}
		
		return $this->delete($ids);
	}
}