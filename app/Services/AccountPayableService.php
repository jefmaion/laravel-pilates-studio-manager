<?php

namespace App\Services;

use App\Models\AccountPayable;


class AccountPayableService extends Services {

    protected $plan;
   
    public function __construct()
    {
        parent::__construct(new AccountPayable());
    }


    


}