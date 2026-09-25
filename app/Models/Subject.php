<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'subject_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'subject_id',
        'subject_name',
    ];

    // ความสัมพันธ์กับ Appointment
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'Subject_subject_id', 'subject_id');
    }
}