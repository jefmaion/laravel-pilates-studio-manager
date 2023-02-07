<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type','description', 'enabled'];

    public function getTypeTextAttribute() {
        $types = ['A' => 'Aparelho/Acessório', 'E' => 'Exercício'];
        return $types[$this->type];
    }
}
