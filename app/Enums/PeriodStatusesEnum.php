<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PeriodStatusesEnum: string implements HasLabel
{
    case Weekly = 'weekly';
    case Monthly = 'monthly';
    case FiveMonths = 'five_months';


public function getLabel(): ?string
{
    return $this->name;
}
}
