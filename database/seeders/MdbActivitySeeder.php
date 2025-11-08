<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MdbActivity;

class MdbActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['user_id' => 1, 'description' => 'Reviewed chapter 1 of MDB.', 'status' => 'pending', 'activity_date' => '2025-10-01'],
            ['user_id' => 2, 'description' => 'Completed assignment on database design.', 'status' => 'completed', 'activity_date' => '2025-10-02'],
            ['user_id' => 3, 'description' => 'Checked student submissions for MDB.', 'status' => 'pending', 'activity_date' => '2025-10-03'],
            ['user_id' => 1, 'description' => 'Prepared notes for next lecture.', 'status' => 'completed', 'activity_date' => '2025-10-04'],
            ['user_id' => 2, 'description' => 'Reviewed feedback from previous activity.', 'status' => 'pending', 'activity_date' => '2025-10-05'],
            ['user_id' => 3, 'description' => 'Updated marks for recent submissions.', 'status' => 'completed', 'activity_date' => '2025-10-06'],
            ['user_id' => 1, 'description' => 'Planned MDB exercises for next week.', 'status' => 'pending', 'activity_date' => '2025-10-07'],
            ['user_id' => 2, 'description' => 'Reviewed lecture slides for MDB.', 'status' => 'completed', 'activity_date' => '2025-10-08'],
            ['user_id' => 3, 'description' => 'Checked pending student queries.', 'status' => 'pending', 'activity_date' => '2025-10-09'],
            ['user_id' => 1, 'description' => 'Finalized reports for MDB session.', 'status' => 'completed', 'activity_date' => '2025-10-10'],
        ];

        foreach ($activities as $activity) {
            MdbActivity::create($activity);
        }
    }
}

