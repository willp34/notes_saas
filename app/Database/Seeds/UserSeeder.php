<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Database\Factories\UserFactory;
use \App\Models\UserModel;


class UserSeeder extends Seeder
{
    public function run()
    {
        //
		
		$userModel = new UserModel();
		
		for($i=0; $i<100;$i++){
			
			$userModel->insert(UserFactory::make());
		}
    }
}
