<?php

namespace App\Services;

use App\Models\AccountPayable;
use Carbon\Carbon;

class AccountPayableService extends Services {

    const FEE = 2;
    const DAY_FEE = 0.033;

    protected $plan;
   
    public function __construct()
    {
        parent::__construct(new AccountPayable());
    }

    public function calculateFees(AccountPayable $account, $dateToPay) {

        
        
        $daysLate  = Carbon::parse($dateToPay)->diffInDays($account->due_date);
        $fees      = ($daysLate * self::DAY_FEE) / 100;

        $account->pay_date = $dateToPay;
        $account->fees = $fees;
        $account->delay_days = $daysLate;
        $account->fee_value = ($account->value * (self::FEE / 100)) + ($account->fees * $account->value);
        $account->value = $account->value +  $account->fee_value;

        return $account;
    }

    public function list($enabled=null) {

        if($enabled !== null) {
            return $this->model->where('enabled', $enabled)->orderBy('id','desc')->get();
        }

        return $this->model->orderBy('due_date','ASC')->get();
    }


    public function sumAccountToPay() {
        return AccountPayable::where('due_date',  '>', date('Y-m-d'))->where('status', 0)->sum('value');
    }

    public function sumAccountLate() {
        return AccountPayable::where('due_date',  '<', date('Y-m-d'))->where('status', 0)->sum('value');
    }

    public function sumAccountPayed() {
        return AccountPayable::where('status', 1)->sum('value');
    }

    public function sumAccountPayToday() {
        return AccountPayable::where('due_date',  '=', date('Y-m-d'))->where('status', 0)->sum('value');
    }
    


}