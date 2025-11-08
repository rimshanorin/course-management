<?php

namespace App\Filament\Instructor\Resources;

use App\Enums\StatusesEnum;
use App\Filament\Instructor\Resources\TicketActivityResource\Pages;
use App\Filament\Instructor\Resources\TicketActivityResource\RelationManagers;
use App\Models\TicketActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketActivityResource extends Resource
{
    protected static ?string $model = TicketActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
     protected static ?string $navigationGroup = 'Instructor Activities';

       protected static ?string $navigationBadgeTooltip = 'Total ticket activities recorded';

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
                   ,
                Forms\Components\TextInput::make('ticket_id')
                 ->label('Ticket ID')
                    ->maxLength(100)
                    ->required(),
                Forms\Components\TextInput::make('description')
                  ->label('Description')
                    ->maxLength(1000)
                    ->nullable()
                    ->columnSpanFull(),
               Forms\Components\Select::make('status')
               ->options(StatusesEnum::class)
                  ->required(),
            //  ->label('Status')
            //         ->options([
            //             'pending' => 'Pending',
            //             'in_progress' => 'In Progress',
            //             'resolved' => 'Resolved',
            //             'closed' => 'Closed',
            //         ])
            //         ->default('pending')
            //         ->required(),
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

                Tables\Columns\TextColumn::make('ticket_id')
                    ->label('Ticket ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->description),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    
                     ->color(fn (StatusesEnum $state): string => match ($state) {
        StatusesEnum::PENDING => 'warning',
        StatusesEnum::IN_PROGRESS => 'info',
        StatusesEnum::RESOLVED => 'success',
        StatusesEnum::CLOSED => 'gray',
        StatusesEnum::COMPLETED => 'success', // optional if you use COMPLETED elsewhere
        StatusesEnum::REPLIED => 'primary',   // optional
        StatusesEnum::OVERDUE => 'danger',    // optional
        default => 'secondary',
                    }),

                Tables\Columns\TextColumn::make('activity_date')
                    ->label('Activity Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                 Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                   // ✅ Quick Action: Mark as Resolved
                Tables\Actions\Action::make('markResolved')
                    ->label('Mark as Resolved')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status !== 'resolved')
                    ->action(function ($record) {
                        $record->update(['status' => 'resolved']);
                    }),
                 Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('markAllResolved')
                        ->label('Mark Selected as Resolved')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['status' => 'resolved']);
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
            'index' => Pages\ListTicketActivities::route('/'),
            'create' => Pages\CreateTicketActivity::route('/create'),
            'edit' => Pages\EditTicketActivity::route('/{record}/edit'),
        ];
    }
}
