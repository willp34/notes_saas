<?php 

namespace  App\Database\Factories;

use Faker\Factory;

class TeamUserFactory
{
	public static function make($teamId,$userId,$overrides =[]){
		
		$faker  = Factory::create();
		return array_merge([
				'team_id' => $teamId,
				'user_id' => $userId,
				'role' => $faker->randomElement(['member','admin'])
		],$overrides);
		}
}