<?php

namespace App\Models;

use App\Enums\ActivityStatusesEnum;
use App\Enums\ActivityTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'description',
        'activity_date',
        'session_week',
        'marks_awarded',
        'ticket_id',
        'email_subject',
    ];

    protected $casts = [
        'type' => ActivityTypesEnum::class,
        'status' => ActivityStatusesEnum::class,
        'activity_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
