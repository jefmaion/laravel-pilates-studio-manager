<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationClass extends Model
{
    use HasFactory;

    protected $fillable = ['instructor_id', 'registration_id', 'time', 'weekday'];

    
}
