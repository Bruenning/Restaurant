<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    
    /**
     * The name of the factory's corresponding model.
     */

    protected $model = \App\Models\User::class;

    /**
     * Define the model's default state.
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => hash('sha256', 'password', false),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }

}
