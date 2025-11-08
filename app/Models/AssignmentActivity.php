<?php

namespace App\Models;

use App\Enums\StatusesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentActivity extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'assignment_title',
        'marks_awarded',
        'description',
        'status',
        'activity_date',
    ];

    protected $casts = [
        'status' => StatusesEnum::class,   // remove or adjust if you're not using enum
        'activity_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
