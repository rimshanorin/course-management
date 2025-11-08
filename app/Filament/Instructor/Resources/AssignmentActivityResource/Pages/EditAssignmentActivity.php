<?php

namespace App\Filament\Instructor\Resources\AssignmentActivityResource\Pages;

use App\Filament\Instructor\Resources\AssignmentActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssignmentActivity extends EditRecord
{
    protected static string $resource = AssignmentActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
