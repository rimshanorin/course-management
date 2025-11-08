<?php

namespace App\Filament\Instructor\Resources\AssignmentActivityResource\Pages;

use App\Filament\Instructor\Resources\AssignmentActivityResource;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab as TabsTab;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ListAssignmentActivities extends ListRecords
{
    protected static string $resource = AssignmentActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array

    {
        return [
            'All' => Tab::make()
                ->icon('heroicon-o-rectangle-stack')
                ->query(fn(Builder $query) => $query)
                ->badge($this->getCount()),

            'Weekly' => Tab::make()
                ->icon('heroicon-o-calendar-days')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->whereBetween('activity_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ])
                )->badge($this->getCount([
                ['activity_date', '>=', now()->startOfWeek()],
                ['activity_date', '<=', now()->endOfWeek()],
            ])),
            'Monthly' => Tab::make()
                ->icon('heroicon-o-calendar')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->whereMonth('activity_date', now()->month)
                )->badge($this->getCount([
                [DB::raw('MONTH(activity_date)'), now()->month],
            ])),
            'Last 5 Months' => Tab::make()
                ->icon('heroicon-o-chart-bar')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('activity_date', '>=', now()->subMonths(5))
                )->badge($this->getCount([
                ['activity_date', '>=', now()->subMonths(5)],
            ])),



        ];
    }
            protected function getCount(array $conditions = []): int
{
    $query = static::getModel()::query();

    foreach ($conditions as $condition) {
        $query->where(...$condition);
    }

    return $query->count();
}
    
}
