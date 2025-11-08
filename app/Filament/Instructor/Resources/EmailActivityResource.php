<?php

namespace App\Filament\Instructor\Resources;

use App\Enums\StatusesEnum;
use App\Filament\Instructor\Resources\EmailActivityResource\Pages;
use App\Filament\Instructor\Resources\EmailActivityResource\RelationManagers;
use App\Models\EmailActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailActivityResource extends Resource
{
    protected static ?string $model = EmailActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
     protected static ?string $navigationGroup = 'Instructor Activities';

        public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count();
    }

    // 🎨 Make the badge color dynamic
    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? 'danger' : 'success'; // red if pending, green if clear
    }

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                   Forms\Components\Select::make('user_id')
                   ->relationship('user', 'name')
                   ->searchable()
                   ->required(),
            Forms\Components\TextInput::make('email_subject')->maxLength(255)->required(),
            Forms\Components\Textarea::make('description')->nullable(),
            Forms\Components\Select::make('status')
              ->label('Status')
                    ->options(StatusesEnum::class)
                    ->required(),
            Forms\Components\DatePicker::make('activity_date')
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
                Tables\Columns\TextColumn::make('email_subject')
                  ->label('Subject')
                    ->searchable()
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
                   Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'replied' => 'Replied',
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
            'index' => Pages\ListEmailActivities::route('/'),
            'create' => Pages\CreateEmailActivity::route('/create'),
            'edit' => Pages\EditEmailActivity::route('/{record}/edit'),
        ];
    }
}
