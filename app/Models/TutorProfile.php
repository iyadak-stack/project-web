<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'experience_years',
        'hourly_rate',
        'total_teaching_hours',
        'average_rating',
        'teaching_mode',
    ];

    // ความสัมพันธ์: TutorProfile เป็นของ User 1 คน (ออมสิน)[cite: 1]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}