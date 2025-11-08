<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusesEnum: string implements HasLabel
{
    case PENDING = 'pending';
case IN_PROGRESS = 'in_progress';
case COMPLETED = 'completed';
case OVERDUE = 'overdue';
case REPLIED = 'replied';
case RESOLVED = 'resolved';
case CLOSED = 'closed';

    public function getLabel(): ?string
    {
        // return $this->name;
         return match($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::OVERDUE => 'Overdue',
            self::REPLIED => 'Replied',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
        };
    }
}
