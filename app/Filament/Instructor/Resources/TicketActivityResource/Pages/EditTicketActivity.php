<?php

namespace App\Filament\Instructor\Resources\TicketActivityResource\Pages;

use App\Filament\Instructor\Resources\TicketActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketActivity extends EditRecord
{
    protected static string $resource = TicketActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
{
    $data['user_id'] = auth()->id();
    return $data;
}
}
