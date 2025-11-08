<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\SessionActivityResource\Pages;
use App\Filament\Instructor\Resources\SessionActivityResource\RelationManagers;
use App\Models\SessionActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SessionActivityResource extends Resource
{
    protected static ?string $model = SessionActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
     protected static ?string $navigationGroup = 'Instructor Activities';

         protected static ?string $navigationBadgeTooltip = 'Total session activities recorded';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Instructor')
                ->required(),
Forms\Components\TextInput::make('session_week')
->numeric()
->label('Session Week')
->required(),
Forms\Components\TextInput::make('attendance_count')
->numeric()
 ->label('Attendance Count')
->nullable(),
Forms\Components\TextInput::make('participation_points')
->numeric()
->label('Participation Points')
->nullable(),
Forms\Components\Textarea::make('notes')
  ->label('Notes')
                    ->maxLength(500)
                    ->nullable()
                    ->columnSpanFull(),
Forms\Components\DatePicker::make('activity_date')
 ->label('Activity Date')
->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Instructor')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('session_week')
                    ->label('Week')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('attendance_count')
                    ->label('Attendance')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 8 => 'success',
                        $state >= 5 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('participation_points')
                    ->label('Participation')
                    ->sortable(),

                Tables\Columns\TextColumn::make('activity_date')
                    ->label('Activity Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                   Tables\Filters\Filter::make('Low Attendance')
                    ->query(fn (Builder $query): Builder => $query->where('attendance_count', '<', 5))
                    ->label('Low Attendance (<5)'),

                Tables\Filters\SelectFilter::make('session_week')
                    ->label('Filter by Week')
                    ->options(
                        SessionActivity::query()
                            ->pluck('session_week', 'session_week')
                            ->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                 Tables\Actions\DeleteAction::make(),


                   // 🟢 Quick Action: Mark as Reviewed
                Tables\Actions\Action::make('markReviewed')
                    ->label('Mark as Reviewed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status !== 'reviewed')
                    ->action(function ($record) {
                        $record->update(['status' => 'reviewed']);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                      Tables\Actions\BulkAction::make('markAllReviewed')
                        ->label('Mark Selected as Reviewed')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'reviewed']);
                            }
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListSessionActivities::route('/'),
            'create' => Pages\CreateSessionActivity::route('/create'),
            'edit' => Pages\EditSessionActivity::route('/{record}/edit'),
        ];
    }
}
