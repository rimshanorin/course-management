<?php

namespace App\Filament\Instructor\Resources\MdbActivityResource\Pages;

use App\Filament\Instructor\Resources\MdbActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMdbActivity extends EditRecord
{
    protected static string $resource = MdbActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
