<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateAccountPayableRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Instructor;
use App\Models\Plan;
use App\Models\Student;
use App\Services\AccountPayableService;
use App\Services\InstructorService;
use App\Services\PlanService;
use App\Services\RegistrationService;
use App\Services\accountPayable;
use App\Traits\Viacep;
use App\View\Components\BadgeStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request as FacadesRequest;

class AccountPayableController extends Controller
{

    use Viacep;

    private $request;
    private $accountPayable;

    public function __construct(Request $request, AccountPayableService $accountPayable)
    {
        $this->accountPayable = $accountPayable;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        if($this->request->ajax()) {
            return $this->list();
        }

        return view('accountPayable.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $account = $this->accountPayable->new(['enabled' => 1]);
        return  view('accountPayable.create', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = requestData($request);

        $account = $this->accountPayable->create($data);

        if($account) {
            return responseRedirect(['accountPayable.show', $account], $this->accountPayable::MSG_CREATE_SUCCESS);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $account
     * @return \Illuminate\Http\Response
     */
    public function show($account)
    {

        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        return view('accountPayable.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $account
     * @return \Illuminate\Http\Response
     */
    public function edit($account)
    {
        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        return  view('accountPayable.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Plan  $account
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountPayableRequest $request, $account)
    {
    
        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        if($account->isLate) {
            $account = $this->calculateTax($account, date('Y-m-d'));
            unset($account->fee_value);
        }

        if(!$this->accountPayable->save($account, requestData($request))) {
            return responseRedirect(['accountPayable.show', $account], $this->accountPayable::MSG_UPDATE_ERROR, 'error');
        } 

        return responseRedirect(['payable.show', $account], $this->accountPayable::MSG_UPDATE_SUCCESS);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($account)
    {
        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index',$this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        if(!$this->accountPayable->destroy($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_DELETE_ERROR, 'error');
        } 

        return responseRedirect('accountPayable.index',$this->accountPayable::MSG_DELETE_SUCCESS);

    }

    public function receive($account) {

        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }
        
        if($account->isLate) {
            $account = $this->calculateTax($account, date('Y-m-d'));
        }


        // $payDate = date('Y-m-d');
        // $fee = 2;
        // $dayFee = 0.033;
        

        // $tax = $account->value * ($fee / 100);
        // $a = ($daysLate * $dayFee) / 100;
        // $taxDays = $a * $account->value;


        // dd($account->value, $tax, $daysLate, $a, $taxDays);

        return view('accountPayable.receive', compact('account'));
    }


    public function calculateTax($account, $dateToPay) {
        $daysLate  = Carbon::parse($dateToPay)->diffInDays($account->due_date);

        $account->pay_date = $dateToPay;
        $account->fees = ($daysLate * 0.033) / 100;
        $account->delay_days = $daysLate;
        $account->fee_value = ($account->value * (2 / 100)) + ($account->fees * $account->value);

        $account->value = $account->value +  $account->fee_value;

        return $account;
    }

    


    public function list()
    {
        $accounts = $this->accountPayable->list();

        foreach($accounts as $i => $account) {


            $accounts[$i] = [
                'description'       =>  sprintf('<a href="%s">%s</a>', route('payable.show', $account), $account->description)  ,
                'value'  =>  'R$ '. USD_BRL($account->value),
                'due_date' => dateDMY($account->due_date),
                'status'     => $account->statusLabel,
            ];
        }

        return responseToDataTable($accounts);
    }
}
