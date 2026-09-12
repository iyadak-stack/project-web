<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'student_id', 'tutor_id', 'subject_id',
        'location_id', 'mode', 'appointment_datetime', 'status',
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
