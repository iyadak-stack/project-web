<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; //PK ไม่ได้เพิ่มเลขอัตโนมัติ
    protected $keyType = 'string'; //PK ของ Model นี้เป็น String

    //อนุญาตให้ id, user_id, bio รับค่าผ่าน create() / update() ได้
    protected $fillable = [
        'id',
        'user_id',
        'bio',
    ];

    // StudentProfile เป็นของ User 1 คน
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
