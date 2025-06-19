<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Database\Factories\TeamUserFactory;
use App\Models\TeamModel;

class TeamUserSeeder extends Seeder
{
    public function run()
    {
        //
		
		$builder = $this->db->table('team_users');
		
		$team_members = [] ;
		$teams = new TeamModel();
		$records	=	$teams->getAllteams();
		for($i=0; $i<800; $i++){
			shuffle($records);
			$team_members[] = TeamUserFactory::make($records[0],rand(538,636));
                 // assumes 100 users already exist with IDs 1–100
            
		}
		
		//$teams[] = TeamUserFactory::make(1,16);       
		//$teams[] = TeamUserFactory::make(102,16);
		//$teams[] = TeamUserFactory::make(103,16);
		//$teams[] = TeamUserFactory::make(104,16);
		$builder->insertBatch($team_members);
    }
}
