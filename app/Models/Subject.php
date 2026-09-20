<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $primaryKey = 'Subjec_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'Subjec_id',
        'subject_name',
    ];

    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(
            TutorProfile::class,
            'Tutor_profiles_has_Subject',
            'Subject_subject_id',
            'Tutor_profiles_tutor_id',
            'Subjec_id',
            'id'
        );
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}