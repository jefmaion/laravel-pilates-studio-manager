<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvolutionExercice extends Model
{
    use HasFactory;

    protected $fillable = ['evolution_id', 'exercice_id', 'comments'];

    public function exercice() {
        return $this->belongsTo(Exercice::class);
    }

}
