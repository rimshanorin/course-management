<?php

namespace App\Filament\Resources;

use App\Enums\PeriodStatusesEnum;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Models\Activity;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('period')
                    ->options(PeriodStatusesEnum::class)
                    ->required(),

                Forms\Components\TextInput::make('total_activities')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('completed')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('pending')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('performance_score')
                    ->numeric()
                    ->step(0.01)
                    ->label('Performance Score (%)'),

                Forms\Components\DateTimePicker::make('generated_at')
                    ->label('Generated At')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('period')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('total_activities')
                    ->sortable(),

                Tables\Columns\TextColumn::make('completed')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pending')
                    ->sortable(),

                Tables\Columns\TextColumn::make('performance_score')
                    ->label('Performance %')
                    ->sortable(),

                Tables\Columns\TextColumn::make('generated_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('period')
                    ->options([
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'five_months' => 'Five Months',
                    ]),
            ])
            ->defaultSort('generated_at', 'desc')
            ->bulkActions([
                // ExportBulkAction::make()
                //     ->exports([
                //         \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
                //             ->fromTable()
                //             ->withFilename('reports_export_' . now()->format('Y_m_d')),
                //     ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Generate Report')
                    ->form([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                        Forms\Components\Select::make('period')
                            ->options([
                                'weekly' => 'Weekly',
                                'monthly' => 'Monthly',
                                'five_months' => 'Five Months',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        $userId = $data['user_id'];
                        $period = $data['period'];

                        $start = now();
                        if ($period === 'weekly') {
                            $start = now()->subWeek();
                        } elseif ($period === 'monthly') {
                            $start = now()->subMonth();
                        } elseif ($period === 'five_months') {
                            $start = now()->subMonths(5);
                        }

                        $query = Activity::where('user_id', $userId)
                            ->whereBetween('activity_date', [$start, now()]);

                        $total = $query->count();
                        $completed = $query->where('status', 'completed')->count();
                        $pending = $total - $completed;

                        Report::updateOrCreate(
                            ['user_id' => $userId, 'period' => $period],
                            [
                                'total_activities' => $total,
                                'completed' => $completed,
                                'pending' => $pending,
                                'performance_score' => $total > 0 ? round(($completed / $total) * 100, 2) : null,
                                'generated_at' => now(),
                            ]
                        );
                    })
                    ->color('success'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
