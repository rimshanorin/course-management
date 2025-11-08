<?php

namespace App\Filament\Instructor\Resources;

use App\Enums\StatusesEnum;
use App\Filament\Instructor\Resources\MdbActivityResource\Pages;
use App\Filament\Instructor\Resources\MdbActivityResource\RelationManagers;
use App\Models\MdbActivity;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MdbActivityResource extends Resource
{
    protected static ?string $model = MdbActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
     protected static ?string $navigationGroup = 'Instructor Activities';

       protected static ?string $navigationBadgeTooltip = 'Number of pending MDBs';

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Instructor'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Description'),
                Select::make('status')
                    ->options(StatusesEnum::class)

                    //  ->options([
                    //     'pending' => 'Pending',
                    //     'completed' => 'Completed',
                    // ])
                    ->required()
                    ->label('Status'),
                Forms\Components\DatePicker::make('activity_date')
                 ->required()
                    ->label('Activity Date'),
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
                Tables\Columns\TextColumn::make('status')
                      ->label('Status')
                    ->sortable()
                    ->badge()
                    // ->colors([
                    //     'warning' => 'pending',
                    //     'success' => 'completed',
                    // ])
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
                      ->label('Activity Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                     ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                       ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListMdbActivities::route('/'),
            'create' => Pages\CreateMdbActivity::route('/create'),
            'edit' => Pages\EditMdbActivity::route('/{record}/edit'),
        ];
    }
}
