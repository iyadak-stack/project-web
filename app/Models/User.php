<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;

class User extends Authenticatable implements PasskeyUser
{
    // ใช้ HasFactory สำหรับสร้างข้อมูลทดสอบ
    use HasFactory, Notifiable, PasskeyAuthenticatable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_role',
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
            'password' => 'hashed',
        ];
    }

    // สร้างชื่อย่อของ User
    public function initials(): string
    {
        return Str::initials($this->name, true);
    }

    // User 1 คน สามารถมี Tutor Profile 1 อัน
    public function tutorProfile(): HasOne
    {
        return $this->hasOne(TutorProfile::class, 'user_id', 'id');
    }

    // User 1 คน สามารถมี Student Profile 1 อัน
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class, 'user_id', 'id');
    }

    // User 1 คน สามารถมี Favorite ได้หลายรายการ
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }
}