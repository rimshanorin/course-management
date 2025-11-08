<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssignmentActivity;
use Carbon\Carbon;

class AssignmentActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [];

        for ($i = 1; $i <= 10; $i++) {
            $activities[] = [
                'user_id' => 1, // make sure user with ID 1 exists, or change to a valid one
                'assignment_title' => "Assignment $i",
                'marks_awarded' => rand(50, 100),
                'description' => "This is a description for Assignment $i",
                'status' => $i % 2 == 0 ? 'completed' : 'pending',
                'activity_date' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        AssignmentActivity::insert($activities);
    }
}

