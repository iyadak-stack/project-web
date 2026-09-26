<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    // ข้อมูลที่สามารถบันทึกได้
    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id',
    ];

    // Favorite เป็นของ User ที่กดบันทึก
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Favorite สามารถอ้างอิงได้ทั้ง Tutor หรือ Subject
    public function favoritable(): MorphTo
    {
        return $this->morphTo();
    }
}