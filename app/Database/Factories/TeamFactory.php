<?php 

namespace  App\Database\Factories;

use Faker\Factory;

class TeamFactory
{
	public static function make($createBy,$overrides =[]){
		
		$faker  = Factory::create();
		return array_merge([
				'name' => $faker->unique()->company,
				'created_by' => $createBy
		],$overrides);
		}
}