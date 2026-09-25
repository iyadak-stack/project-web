<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'student_id', 
        'line_id', 
        'discord_id', 
        'google_meet_link', 
        'zoom_link'];
}
