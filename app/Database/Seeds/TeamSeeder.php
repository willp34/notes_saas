<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Database\Factories\TeamFactory;
use App\Database\Factories\TeamUserFactory;
use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\TeamUserModel;

class TeamSeeder extends Seeder
{
    public function run()
    {
        //

		$builder = $this->db->table('teams');
		$teamModel = new TeamModel();
		$teamMember= new TeamUserModel();
		$teams = [] ;
		$users  = new UserModel();
		$records = $users->getAllUsers();
		
		//print_r($records);
		for($i=2; $i<=20; $i++){
			// Use shuffle function to randomly assign numeric
			// key to all elements of array.
			shuffle($records);
			
			 $teamData =TeamFactory::make( $records[0]) ;
			 $teamModel->insert($teamData);
			 $teamId = $teamModel->getInsertID();
			 
			 $memberData =TeamUserFactory::make($teamId,$records[0]);
			 $teamMember->insert($memberData);
			//$teams[] =  TeamFactory::make(); 
		}
		//$builder->insertBatch($teams);
    }
}
