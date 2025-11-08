<?php

namespace App\Filament\Instructor\Widgets;

use App\Models\AssignmentActivity;
use App\Models\EmailActivity;
use App\Models\GdbActivity;
use App\Models\MdbActivity;
use App\Models\SessionActivity;
use App\Models\TicketActivity;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsInstructorOverview extends BaseWidget
{
    protected function getStats(): array
    {
          $user = Auth::user();

        $models = [
            AssignmentActivity::class,
            TicketActivity::class,
            EmailActivity::class,
            GdbActivity::class,
            MdbActivity::class,
            SessionActivity::class,
        ];

        $total = 0;
        $pending = 0;
        $completed = 0;
        $overdue = 0;

        foreach ($models as $model) {
            $total += $model::where('user_id', $user->id)->count();

            $pending += $model::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $completed += $model::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count();

            $overdue += $model::where('user_id', $user->id)
                ->where('status', 'pending')
                ->whereNotNull('activity_date')
                ->whereDate('activity_date', '<', now()->toDateString())
                ->count();
               
        }
        return [
              Stat::make('📚 Total My Activities', $total)
                ->description('All tasks assigned to you')
                ->color('primary'),

            Stat::make('🕒 Pending Tasks', $pending)
                ->description('Activities waiting for your action')
                ->color('warning'),

            Stat::make('✅ Completed Tasks', $completed)
                ->description('Activities you have finished')
                ->color('success'),

            Stat::make('⚠️ Overdue Tasks', $overdue)
                ->description('Pending tasks past their due date')
                ->color('danger'),
        ];
    }
}
