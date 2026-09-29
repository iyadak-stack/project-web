<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'favoritable_type',
        'favoritable_id',
    ];

    // Favorite เป็นของ User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Favorite อ้างอิงได้ทั้ง Tutor หรือ Subject
    public function favoritable(): MorphTo
    {
        return $this->morphTo();
    }
}