<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GdbActivity;
use App\Models\User;
use Faker\Factory as Faker;

class GdbActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all user IDs
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->info('No users found! Please create some users first.');
            return;
        }

        // Create 10 GDB activities
        for ($i = 0; $i < 10; $i++) {
            GdbActivity::create([
                'user_id' => $faker->randomElement($userIds),
                'gdb_identifier' => 'GDB-' . $faker->unique()->numberBetween(1000, 9999),
                'marks_awarded' => $faker->numberBetween(0, 100),
                'notes' => $faker->sentence(10, true),
                'status' => $faker->randomElement(['pending', 'completed']),
                'activity_date' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            ]);
        }
    }
}

