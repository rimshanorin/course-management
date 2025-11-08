<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ActivityTypesEnum: string implements HasLabel
{
    case MDB = 'mdb';
    case Ticket = 'ticket';
    case Assignment = 'assignment';
    case GDB = 'gdb';
    case Session = 'session';
    case Email = 'email';


public function getLabel(): ?string
{
    return $this->name;
}
}
