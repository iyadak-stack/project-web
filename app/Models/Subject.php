<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['tutor_id', 'subject_name'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
