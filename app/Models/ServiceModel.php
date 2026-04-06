<?php  
namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
	protected $table = "services";
	protected $primaryKey= 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['title','description', 'service_id', 'price'];
	protected $useTimestamps = false;


    public function getProduct_and_Services(){
		
			// Check tables exist
		if (
			!$this->db->tableExists($this->table) 
			
		) {
			return "table not  available"; // prevent crash
		}
	
		$rows = $this->db->table($this->table.' p')
		->select('p.id As id, p.title As Product_title, p.description As Product_description,
		 s.title AS service_title, s.description AS service_decription, s.price AS price')
		->join($this->table.' s ','s.service_id=p.id ')
		->get()
		->getResultArray();
		
		$products = [];
		
		foreach ($rows as $row){

				$id = $row['id'];
				// create product if not exists
				if(!isset($products[$id])){
					$products[$id]  = [
						'title'  =>$row['Product_title'],
						'services' => []
						
					] ;
					
				}
				// add service
				
				if($row['service_title']){
					$products[$id]['services'][] = $row;
				}
		}
		return $products ;
	
	}
}

	