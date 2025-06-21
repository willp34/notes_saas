<@php

namespace {namespace};

use CodeIgniter\Database\Factories\Factory;

class {class} extends Factory
{
    public function definition(): array
    {
        return [
            'name'  => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
    
