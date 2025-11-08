<?php

namespace App\Models;

use App\Enums\PeriodStatusesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'period',
        'total_activities',
        'completed',
        'pending',
        'performance_score',
        'generated_at',
    ];

    protected $casts = [
        'period' => PeriodStatusesEnum::class,
        'generated_at' => 'datetime',
        'performance_score' => 'decimal:2',
    ];

    /**
     * Relationship: Report belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
