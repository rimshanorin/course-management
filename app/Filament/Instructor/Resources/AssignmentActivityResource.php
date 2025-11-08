<?php

namespace App\Filament\Instructor\Resources;

use App\Enums\StatusesEnum;
use App\Filament\Instructor\Resources\AssignmentActivityResource\Pages;
use App\Filament\Instructor\Resources\AssignmentActivityResource\RelationManagers;
use App\Models\AssignmentActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignmentActivityResource extends Resource
{
    protected static ?string $model = AssignmentActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Instructor Activities';





    public static function getNavigationBadge(): ?string

    {
        // Example: show count of pending assignments
        return (string) AssignmentActivity::where('status', 'pending')->count();
    }


    // Optional: you can color it
    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning'; // choices: 'primary', 'success', 'danger', 'warning', etc.
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\TextInput::make('assignment_title')
                    ->maxLength(255),

                Forms\Components\TextInput::make('marks_awarded')
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')


                 ->label('Status')
                    ->options(StatusesEnum::class)
                    ->required(),
                Forms\Components\DatePicker::make('activity_date'),
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
                Tables\Columns\TextColumn::make('assignment_title')
                ->label('Assignment')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('marks_awarded')
                ->label('Marks'),
                Tables\Columns\TextColumn::make('status')
                //
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
                ->date()
                ->label('Date')
                ->sortable(),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('status')   ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'overdue' => 'Overdue',
                        'replied' => 'Replied',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
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
            'index' => Pages\ListAssignmentActivities::route('/'),
            'create' => Pages\CreateAssignmentActivity::route('/create'),
            'edit' => Pages\EditAssignmentActivity::route('/{record}/edit'),
        ];
    }
}
