<?php 

namespace  App\Database\Factories;

use Faker\Factory;

class UserFactory
{
	public static function make($overrides =[]){
		
		$faker  = Factory::create();
		return array_merge([
				'email' => $faker->unique()->safeEmail,
				'password' => password_hash('password',PASSWORD_DEFAULT),
				'created_at' => date('Y-m-d  H:i:S')
		],$overrides);
		}
}