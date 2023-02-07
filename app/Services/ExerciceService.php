<?php

namespace App\Services;

use App\Models\Exercice;

class ExerciceService extends Services {

    public function __construct()
    {
        parent::__construct(new Exercice());

    }
}