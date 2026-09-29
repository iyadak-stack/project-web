<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;

class User extends Authenticatable implements PasskeyUser
{
    use HasFactory, Notifiable, SoftDeletes, PasskeyAuthenticatable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'is_active',
        'current_role',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ใช้แสดงชื่อเต็มในหน้าเดิมที่เรียก $user->name
    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    // ใช้แสดงตัวอักษรย่อของชื่อ
    public function initials(): string
    {
        return Str::initials($this->name, true);
    }

    // User 1 คนมี Tutor Profile ได้ 1 อัน
    public function tutorProfile(): HasOne
    {
        return $this->hasOne(TutorProfile::class, 'user_id', 'user_id');
    }

    // User 1 คนมี Student Profile ได้ 1 อัน
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, 'user_id', 'user_id');
    }

    // User 1 คนมี Favorite ได้หลายรายการ
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'user_id');
    }
}