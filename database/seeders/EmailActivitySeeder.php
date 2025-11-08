<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailActivity;
use App\Models\User;
use Illuminate\Support\Str;

class EmailActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all user IDs to assign randomly
        $userIds = User::pluck('id')->toArray();

        // Check if there are users
        if (empty($userIds)) {
            $this->command->info('No users found! Please create some users first.');
            return;
        }

        // Create 10 dummy email activities
        for ($i = 1; $i <= 10; $i++) {
            EmailActivity::create([
                'user_id' => $userIds[array_rand($userIds)],
                'email_subject' => 'Sample Email Subject ' . $i,
                'description' => 'This is a sample description for email activity number ' . $i . '.',
                'status' => (rand(0, 1) ? 'pending' : 'replied'),
                'activity_date' => now()->subDays(rand(0, 30)), // random date within last 30 days
            ]);
        }
    }
}

