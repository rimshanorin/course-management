<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ActivityStatusesEnum: string implements HasLabel
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
