<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassExercice extends Model
{
    use HasFactory;
    protected $fillable = ['classes_id', 'exercice_id', 'student_id', 'comments'];


    public function exercice() {
        return $this->belongsTo(Exercice::class);
    }

    public function classes() {
        return $this->belongsTo(Classes::class, 'id', 'classes_id');
    }
}
