<?php

namespace App\Services;

use App\Models\Classes;
use App\Models\ClassExercice;
use App\Models\Evolution;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class ClassService extends Services
{
    public function __construct()
    {
        parent::__construct(new Classes);
    }


    
}
