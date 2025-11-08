<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketActivity;

class TicketActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            ['user_id' => 1, 'ticket_id' => 'TKT-001', 'description' => 'Issue with login page', 'status' => 'pending', 'activity_date' => '2025-10-01'],
            ['user_id' => 2, 'ticket_id' => 'TKT-002', 'description' => 'Error in payment gateway', 'status' => 'in_progress', 'activity_date' => '2025-10-02'],
            ['user_id' => 3, 'ticket_id' => 'TKT-003', 'description' => 'Bug in dashboard charts', 'status' => 'resolved', 'activity_date' => '2025-10-03'],
            ['user_id' => 1, 'ticket_id' => 'TKT-004', 'description' => 'Unable to upload files', 'status' => 'closed', 'activity_date' => '2025-10-04'],
            ['user_id' => 2, 'ticket_id' => 'TKT-005', 'description' => 'Notification emails not sent', 'status' => 'pending', 'activity_date' => '2025-10-05'],
            ['user_id' => 3, 'ticket_id' => 'TKT-006', 'description' => 'Profile update failing', 'status' => 'in_progress', 'activity_date' => '2025-10-06'],
            ['user_id' => 1, 'ticket_id' => 'TKT-007', 'description' => 'Incorrect report generation', 'status' => 'resolved', 'activity_date' => '2025-10-07'],
            ['user_id' => 2, 'ticket_id' => 'TKT-008', 'description' => 'Slow loading pages', 'status' => 'closed', 'activity_date' => '2025-10-08'],
            ['user_id' => 3, 'ticket_id' => 'TKT-009', 'description' => 'Search not returning results', 'status' => 'pending', 'activity_date' => '2025-10-09'],
            ['user_id' => 1, 'ticket_id' => 'TKT-010', 'description' => 'Database connection timeout', 'status' => 'in_progress', 'activity_date' => '2025-10-10'],
        ];

        foreach ($activities as $activity) {
            TicketActivity::create($activity);
        }
    }
}

