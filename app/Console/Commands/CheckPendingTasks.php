<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DeadlineReminderNotification;
use App\Models\AssignmentActivity;
use App\Models\TicketActivity;
use App\Models\EmailActivity;
use App\Models\GdbActivity;
use App\Models\MdbActivity;
use App\Models\SessionActivity;

class CheckPendingTasks extends Command
{
    protected $signature = 'tasks:check-deadlines {--days=1 : lookahead days for upcoming deadlines}';
    protected $description = 'Check for pending or overdue tasks and notify responsible users';

    public function handle()
    {
        $this->info('Checking pending tasks...');

        $days = (int)$this->option('days');
        $threshold = now()->addDays($days);

        $models = [
            'assignment' => AssignmentActivity::class,
            'ticket' => TicketActivity::class,
            'email' => EmailActivity::class,
            'gdb' => GdbActivity::class,
            'mdb' => MdbActivity::class,
            'session' => SessionActivity::class,
        ];

        foreach ($models as $label => $model) {
            $records = $model::where('status', 'pending')
                ->whereNotNull('activity_date')
                ->whereDate('activity_date', '<=', $threshold)
                ->get();

            foreach ($records as $record) {
                if ($record->user && $record->user->email) {
                    try {
                        Notification::send($record->user, new DeadlineReminderNotification($record, $label));
                        $this->info("Notified user id {$record->user->id} about {$label} id {$record->id}");
                    } catch (\Throwable $e) {
                        $this->error("Failed notifying for {$label} id {$record->id}: " . $e->getMessage());
                    }
                }
            }
        }

        $this->info('Done.');
    }
}
