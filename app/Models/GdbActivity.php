<?php

namespace App\Models;

use App\Enums\StatusesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GdbActivity extends Model
{
    use HasFactory;
      protected $fillable = [
        'user_id',
        'gdb_identifier',
        'marks_awarded',
        'notes',
        'status',
        'activity_date',
    ];

    protected $casts = [
        'status' => StatusesEnum::class,
        'activity_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
