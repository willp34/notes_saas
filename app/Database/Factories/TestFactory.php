<?php
namespace App\Database\Factories;

use CodeIgniter\Database\Seeder;

class TestFactory extends Seeder
{
    public function definition(): array
    {
        return [
            'name'  => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
    
