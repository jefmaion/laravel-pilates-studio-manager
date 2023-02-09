<?php

namespace App\Services;

use App\Models\AccountPayable;


class AccountPayableService extends Services {

    protected $plan;
   
    public function __construct()
    {
        parent::__construct(new AccountPayable());
    }


    public function list($enabled=null) {

        if($enabled !== null) {
            return $this->model->where('enabled', $enabled)->orderBy('id','desc')->get();
        }

        return $this->model->orderBy('due_date','ASC')->get();
    }


}