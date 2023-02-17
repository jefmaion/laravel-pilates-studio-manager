<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateAccountPayableRequest;
use App\Models\PaymentMethod;
use App\Services\AccountPayableService;
use Illuminate\Http\Request;

class AccountPayableController extends Controller
{
    private $request;
    private $accountPayable;

    public function __construct(Request $request, AccountPayableService $accountPayable)
    {
        $this->accountPayable = $accountPayable;
        $this->request = $request;
    }

    public function index()
    {    
        if($this->request->ajax()) {
            return $this->list();
        }

        return view('accountPayable.index');
    }

    public function create()
    {
        $account = $this->accountPayable->new(['enabled' => 1]);
        return  view('accountPayable.create', compact('account'));
    }

    public function store(Request $request)
    {
        $data = requestData($request);

        $account = $this->accountPayable->create($data);

        if($account) {
            return responseRedirect(['accountPayable.show', $account], $this->accountPayable::MSG_CREATE_SUCCESS);
        } 
    }

    public function show($account)
    {
        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        return view('accountPayable.show', compact('account'));
    }

    public function edit($account)
    {
        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        return  view('accountPayable.edit', compact('account'));
    }

    public function update(UpdateAccountPayableRequest $request, $account)
    {
    
        if(!$account = $this->accountPayable->find($account)) {
            return responseRedirect('accountPayable.index', $this->accountPayable::MSG_NOT_FOUND, 'error');
        }

        if($account->isLate) {
            $account = $this->accountPayable->calculateFees($account, date('Y-m-d'));
            $account->fees = $account->fee_value;
            unset($account->fee_value);
        }


        if(!$this->accountPayable->save($account, requestData($request))) {
            return responseRedirect(['accountPayable.show', $account], $this->accountPayable::MSG_UPDATE_ERROR, 'error');
        } 

        return responseRedirect('payable.index', $this->accountPayable::MSG_UPDATE_SUCCESS);

    }

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
            $account = $this->accountPayable->calculateFees($account, date('Y-m-d'));
        }

        $paymentMethods = $this->toSelectBox(PaymentMethod::all(), 'id', 'name');

        return view('accountPayable.receive', compact('account', 'paymentMethods'));
    }
    
    public function list()
    {
        $accounts = $this->accountPayable->list();

        foreach($accounts as $i => $account) {

            $accounts[$i] = [
                'created_at' => dateDMY($account->created_at),
                'description'       =>  sprintf('<a href="%s">%s</a>', route('payable.show', $account), $account->description)  ,
                'value'  =>  'R$ '. USD_BRL($account->value),
                'due_date' => dateDMY($account->due_date),
                'status'     => $account->statusLabel,
                'payment_method'     => $account->paymentMethod->name,
            ];
        }

        return responseToDataTable($accounts);
    }
}
