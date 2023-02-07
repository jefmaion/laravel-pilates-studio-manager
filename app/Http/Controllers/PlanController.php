<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Services\PlanService;
use App\Traits\Viacep;
use App\View\Components\Badge;
use App\View\Components\BadgeStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlanController extends Controller
{

    private $request;
    private $planService;

    public function __construct(Request $request,  PlanService $planService)
    {
        $this->planService = $planService;
        $this->request     = $request;
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

        return view('plan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = $this->planService->new(['enabled' => 1]);
        return  view('plan.create', compact('plan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanRequest $request)
    {
        $data = requestData($request);

        $plan = $this->planService->create($data);

        if($plan) {
            return responseRedirect(['plan.show', $plan], $this->planService::MSG_CREATE_SUCCESS . ' (<a href="'.route('plan.create').'">Adicionar outro plano</a>)');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show($plan, Request $request)
    {

        $plan = $this->planService->find($plan);

        if($this->request->ajax()) {
            if(!$plan) {
                return responseJSON(['error' => $this->planService::MSG_NOT_FOUND]);
            }
            return responseJSON($plan);
        }

        if(!$plan) {
            return responseRedirect('plan.index', $this->planService::MSG_NOT_FOUND, 'error');
        }

        return view('plan.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($plan)
    {
        if(!$plan = $this->planService->find($plan)) {
            return responseRedirect('plan.index', $this->planService::MSG_NOT_FOUND, 'error');
        }

        return  view('plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlanRequest  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, $plan)
    {
    
        if(!$plan = $this->planService->find($plan)) {
            return responseRedirect('plan.index', $this->planService::MSG_NOT_FOUND, 'error');
        }

        if(!$this->planService->save($plan, requestData($request))) {
            return responseRedirect(['plan.show', $plan], $this->planService::MSG_UPDATE_ERROR, 'error');
        } 

        return responseRedirect(['plan.show', $plan], $this->planService::MSG_UPDATE_SUCCESS);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($plan)
    {
        if(!$plan = $this->planService->find($plan)) {
            return responseRedirect('plan.index',$this->planService::MSG_NOT_FOUND, 'error');
        }

        if(!$this->planService->destroy($plan)) {
            return responseRedirect('plan.index', $this->planService::MSG_DELETE_ERROR, 'error');
        } 

        return responseRedirect('plan.index',$this->planService::MSG_DELETE_SUCCESS);

    }


    public function list()
    {
        $plans = $this->planService->list();

        foreach($plans as $i => $plan) {

            $plan->name   = sprintf('<a href="%s">%s</a>', route('plan.show', $plan), $plan->name);
            $plan->status = component(new BadgeStatus($plan->enabled));
            $plan->value  = USD_BRL($plan->value);

            $plans[$i] = $plan;
        }

        return responseToDataTable($plans);
    }
}
