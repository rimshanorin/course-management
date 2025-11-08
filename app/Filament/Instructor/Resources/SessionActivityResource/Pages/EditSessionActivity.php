<?php

namespace App\Filament\Instructor\Resources\SessionActivityResource\Pages;

use App\Filament\Instructor\Resources\SessionActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSessionActivity extends EditRecord
{
    protected static string $resource = SessionActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
