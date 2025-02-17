<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name'              => $this->faker->name,
            'email'             => $this->faker->unique()->safeEmail,
            'cpf'               => $this->faker->numerify('###########'), // Generates an 11-digit number
            'email_verified_at' => now(),
            'password'          => bcrypt('password'), // Or use Hash::make('password')
            'remember_token'    => Str::random(10),
            'role'              => 'employee', // Default role can be 'employee'
        ];
    }
}
