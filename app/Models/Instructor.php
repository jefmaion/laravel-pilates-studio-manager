<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'comments',
        'enabled',
        'profession',
        'profession_document',
        'remunaration_type',
        'remuneration_value',
        'calc_on_absense'
    ];



    public function getNameAttribute() {
        return $this->user->name;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
