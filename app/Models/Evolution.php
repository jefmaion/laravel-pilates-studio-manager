<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evolution extends Model
{
    use HasFactory;


    protected $fillable = ['classes_id', 'instructor_id', 'student_id', 'evolution'];


    public function classes() {
        return $this->belongsTo(Classes::class);
    }

    public function instructor() {
        return $this->belongsTo(Instructor::class);
    }

    public function exercices() {
        return $this->hasMany(EvolutionExercice::class);
    }
}
