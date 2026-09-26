<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    // ข้อมูลที่สามารถบันทึกหรือแก้ไขได้
    protected $fillable = [
        'user_id',
        'bio',
    ];

    // Student Profile เป็นของ User 1 คน
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
