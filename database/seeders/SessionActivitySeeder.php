<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SessionActivity;

class SessionActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['user_id' => 1, 'session_week' => 1, 'attendance_count' => 8, 'participation_points' => 10, 'notes' => 'Active participation.', 'activity_date' => '2025-10-01'],
            ['user_id' => 2, 'session_week' => 1, 'attendance_count' => 6, 'participation_points' => 7, 'notes' => 'Good questions asked.', 'activity_date' => '2025-10-01'],
            ['user_id' => 3, 'session_week' => 1, 'attendance_count' => 4, 'participation_points' => 5, 'notes' => 'Needs improvement.', 'activity_date' => '2025-10-01'],
            ['user_id' => 1, 'session_week' => 2, 'attendance_count' => 9, 'participation_points' => 12, 'notes' => 'Excellent contribution.', 'activity_date' => '2025-10-08'],
            ['user_id' => 2, 'session_week' => 2, 'attendance_count' => 5, 'participation_points' => 6, 'notes' => 'Average performance.', 'activity_date' => '2025-10-08'],
            ['user_id' => 3, 'session_week' => 2, 'attendance_count' => 7, 'participation_points' => 8, 'notes' => 'Good engagement.', 'activity_date' => '2025-10-08'],
            ['user_id' => 1, 'session_week' => 3, 'attendance_count' => 10, 'participation_points' => 15, 'notes' => 'Outstanding.', 'activity_date' => '2025-10-15'],
            ['user_id' => 2, 'session_week' => 3, 'attendance_count' => 3, 'participation_points' => 4, 'notes' => 'Low attendance.', 'activity_date' => '2025-10-15'],
            ['user_id' => 3, 'session_week' => 3, 'attendance_count' => 6, 'participation_points' => 7, 'notes' => 'Satisfactory.', 'activity_date' => '2025-10-15'],
            ['user_id' => 1, 'session_week' => 4, 'attendance_count' => 8, 'participation_points' => 10, 'notes' => 'Consistent performance.', 'activity_date' => '2025-10-22'],
        ];

        foreach ($activities as $activity) {
            SessionActivity::create($activity);
        }
    }
}

