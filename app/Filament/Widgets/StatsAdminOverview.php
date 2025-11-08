<?php

namespace App\Filament\Widgets;

use App\Models\AssignmentActivity;
use App\Models\EmailActivity;
use App\Models\GdbActivity;
use App\Models\MdbActivity;
use App\Models\SessionActivity;
use App\Models\TicketActivity;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
          $models = [
            AssignmentActivity::class,
            SessionActivity::class,
            TicketActivity::class,
            EmailActivity::class,
            GdbActivity::class,
            MdbActivity::class,
        ];

        $totalActivities = 0;
        $pendingActivities = 0;
        $completedActivities = 0;
        $overdueActivities = 0;

        foreach ($models as $model) {
            $totalActivities += $model::count();

            $pendingActivities += $model::where('status', 'pending')->count();
            $completedActivities += $model::where('status', 'completed')->count();

            $overdueActivities += $model::where('status', 'pending')
                ->whereNotNull('activity_date')
                ->whereDate('activity_date', '<', now()->toDateString())
                ->count();
        }

        $totalUsers = User::count();
        return [
        //          Stat::make('Unique views', '192.1k'),
        //     Stat::make('Bounce rate', '21%'),
        //     Stat::make('Average time on page', '3:12'),
           Stat::make('👥 Total Users', $totalUsers)
                ->description('Registered users in the system')
                ->color('info'),

            Stat::make('🗂️ Total Activities', $totalActivities)
                ->description('All activities recorded across modules')
                ->color('primary'),

            Stat::make('🕒 Pending Activities', $pendingActivities)
                ->description('Tasks awaiting completion')
                ->color('warning'),

            Stat::make('✅ Completed Activities', $completedActivities)
                ->description('Tasks successfully completed')
                ->color('success'),

            Stat::make('⚠️ Overdue Activities', $overdueActivities)
                ->description('Pending tasks past due date')
                ->color('danger'),
         ];
    }
}
