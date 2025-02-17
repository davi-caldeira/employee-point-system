<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class EmployeeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        // Retrieve the admin user (assumed to be seeded with email "admin@example.com")
        $admin = User::where('email', 'admin@example.com')->first();

        if (!$admin) {
            $this->command->error('Admin user not found! Please seed the admin first.');
            return;
        }

        // Create an employee managed by the admin
        User::create([
            'name'       => $faker->name,
            'cpf'        => $faker->numerify('###########'), 
            'email'      => $faker->unique()->safeEmail,
            'password'   => Hash::make('employee123'),
            'role'       => 'employee',
            'position'   => $faker->jobTitle,
            'birth_date' => $faker->date('Y-m-d', '2000-01-01'),
            'zip_code'   => $faker->postcode,
            'address'    => $faker->streetAddress . ', ' . $faker->city . ' - ' . $faker->stateAbbr,
            'created_by' => $admin->id, // dynamically set based on the seeded admin user
        ]);
    }
}
