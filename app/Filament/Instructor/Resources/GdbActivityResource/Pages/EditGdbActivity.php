<?php

namespace App\Filament\Instructor\Resources\GdbActivityResource\Pages;

use App\Filament\Instructor\Resources\GdbActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGdbActivity extends EditRecord
{
    protected static string $resource = GdbActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
