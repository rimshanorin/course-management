<?php

namespace App\Filament\Resources;

use App\Enums\ActivityStatusesEnum;
use App\Enums\ActivityTypesEnum;
use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('type')
                    ->options(ActivityTypesEnum::class)
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options(ActivityStatusesEnum::class)
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->maxLength(1000)
                    ->nullable(),

                Forms\Components\DatePicker::make('activity_date')
                    ->required(),

                Forms\Components\TextInput::make('session_week')
                    ->numeric()
                    ->nullable(),

                Forms\Components\TextInput::make('marks_awarded')
                    ->numeric()
                    ->nullable(),

                Forms\Components\TextInput::make('ticket_id')
                    ->maxLength(255)
                    ->nullable(),

                Forms\Components\TextInput::make('email_subject')
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Instructor')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->limit(40)
                    ->wrap(),

                Tables\Columns\TextColumn::make('activity_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('session_week')->sortable(),
                Tables\Columns\TextColumn::make('marks_awarded'),
                Tables\Columns\TextColumn::make('ticket_id'),
                Tables\Columns\TextColumn::make('email_subject'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Created')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
