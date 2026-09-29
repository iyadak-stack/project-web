<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TutorProfile extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; //PK นี้ไม่ต้องเพิ่มเลขอัตโนมัติ
    protected $keyType = 'string'; //PK เป็นข้อมูลประเภท String

    protected $fillable = [
        'id',
        'user_id',
        'bio',
        'experience_years',
        'average_rating',
        'teaching_mode',
    ];

    // TutorProfile เป็นของ User 1 คน
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Tutor 1 คนสอนได้หลายวิชา
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(
            Subject::class,
            'Tutor_profiles_has_Subject',
            'Tutor_profiles_tutor_id',
            'Subject_subject_id',
            'id',
            'subject_id'
        );
    }
}