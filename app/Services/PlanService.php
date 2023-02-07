<?php

namespace App\Services;

use App\Models\Plan;


class PlanService extends Services {


   
    public function __construct()
    {
        parent::__construct(new Plan);

    }



}