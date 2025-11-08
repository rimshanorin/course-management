<?php

namespace App\Models;

use App\Enums\StatusesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketActivity extends Model
{
    use HasFactory;

      public $fillable = [
       
        'ticket_id',
        'description',
        'status',
        'activity_date'
    ];

    protected $casts = [
        'status' => StatusesEnum::class,
        'activity_date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
