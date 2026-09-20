<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['location_name', 'latitude', 'longitude'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
