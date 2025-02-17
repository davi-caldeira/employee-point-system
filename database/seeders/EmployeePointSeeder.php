<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EmployeePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        // Retrieve all employee users (role = 'employee')
        $employees = User::where('role', 'employee')->get();

        foreach ($employees as $employee) {
            // Create a random number of points for each employee (e.g., between 3 and 7)
            $pointsCount = $faker->numberBetween(3, 7);
            for ($i = 0; $i < $pointsCount; $i++) {
                Point::create([
                    'user_id'       => $employee->id,
                    // Register the point at a random time within the last 30 days
                    'registered_at' => Carbon::now()->subDays($faker->numberBetween(0, 30))->toDateTimeString(),
                ]);
            }
        }
    }
}
