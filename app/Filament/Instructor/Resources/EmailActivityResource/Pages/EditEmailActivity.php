<?php

namespace App\Filament\Instructor\Resources\EmailActivityResource\Pages;

use App\Filament\Instructor\Resources\EmailActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmailActivity extends EditRecord
{
    protected static string $resource = EmailActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
