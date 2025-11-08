<?php

namespace App\Filament\Instructor\Resources;

use App\Enums\StatusesEnum;
use App\Filament\Instructor\Resources\GdbActivityResource\Pages;
use App\Filament\Instructor\Resources\GdbActivityResource\RelationManagers;
use App\Models\GdbActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GdbActivityResource extends Resource
{
    protected static ?string $model = GdbActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
     protected static ?string $navigationGroup = 'Instructor Activities';
        public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count();
    }

    /**
     * 🎨 Badge color — Red if pending, green if all completed
     */
    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? 'danger' : 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                  Forms\Components\Select::make('user_id')
                  ->label('Instructor')
                  ->relationship('user', 'name')
                  ->searchable()
                  ->required(),
            Forms\Components\TextInput::make('gdb_identifier')
            ->label('GDB ID')
            ->required()
            ->maxLength(255),
            Forms\Components\TextInput::make('marks_awarded')
            ->label('Marks Awarded')
            ->numeric()
            ->nullable(),
            Forms\Components\Textarea::make('notes')
            ->label('Notes')
            ->nullable(),
            Forms\Components\Select::make('status')
            ->label('Status')
                    ->options(StatusesEnum::class)
                    ->required(),
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
                                 ->searchable()
                                ->sortable(),
                Tables\Columns\TextColumn::make('gdb_identifier')
                ->label('GDB')
                ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('marks_awarded'
                )->label('Marks')
                ->sortable(),
                Tables\Columns\TextColumn::make('status')
                 ->label('Status')
                    ->badge()
                    ->color(fn (StatusesEnum $state): string => match ($state) {
                        StatusesEnum::PENDING => 'warning',
                        StatusesEnum::IN_PROGRESS => 'info',
                        StatusesEnum::COMPLETED => 'success',
                        StatusesEnum::OVERDUE => 'danger',
                        StatusesEnum::REPLIED => 'primary',
                        StatusesEnum::RESOLVED => 'success',
                        StatusesEnum::CLOSED => 'gray',
                        default => 'secondary',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('activity_date')
                ->label('Date')
                ->date()
                ->sortable(),
            ])
            ->filters([
                  Tables\Filters\SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListGdbActivities::route('/'),
            'create' => Pages\CreateGdbActivity::route('/create'),
            'edit' => Pages\EditGdbActivity::route('/{record}/edit'),
        ];
    }
}

