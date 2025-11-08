<?php

namespace App\Filament\Instructor\Resources\TicketActivityResource\Pages;

use App\Filament\Instructor\Resources\TicketActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketActivity extends CreateRecord
{
    protected static string $resource = TicketActivityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = auth()->id(); // automatically set the current logged-in user
    return $data;
}
}
