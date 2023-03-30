<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use App\Http\Requests\StoreExerciceRequest;
use App\Http\Requests\UpdateExerciceRequest;
use App\Services\ExerciceService;
use App\View\Components\BadgeStatus;
use Illuminate\Http\Request;

class ExerciceController extends Controller
{
    private $request;
    private $exerciceService;

    public function __construct(Request $request,  ExerciceService $exerciceService)
    {
        $this->exerciceService = $exerciceService;
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

        return view('exercice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exercice = $this->exerciceService->new(['enabled' => 1]);
        return  view('exercice.create', compact('exercice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExerciceRequest $request)
    {
        $data = requestData($request);

        $exercice = $this->exerciceService->create($data);

        if($exercice) {
            return responseRedirect(['exercice.show', $exercice], $this->exerciceService::MSG_CREATE_SUCCESS . ' (<a href="'.route('exercice.create').'">Adicionar outro plano</a>)');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $exercice
     * @return \Illuminate\Http\Response
     */
    public function show($exercice, Request $request)
    {

        $exercice = $this->exerciceService->find($exercice);

        if($this->request->ajax()) {
            if(!$exercice) {
                return responseJSON(['error' => $this->exerciceService::MSG_NOT_FOUND]);
            }
            return responseJSON($exercice);
        }

        if(!$exercice) {
            return responseRedirect('exercice.index', $this->exerciceService::MSG_NOT_FOUND, 'error');
        }

        return view('exercice.show', compact('exercice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $exercice
     * @return \Illuminate\Http\Response
     */
    public function edit($exercice)
    {
        if(!$exercice = $this->exerciceService->find($exercice)) {
            return responseRedirect('exercice.index', $this->exerciceService::MSG_NOT_FOUND, 'error');
        }

        return  view('exercice.edit', compact('exercice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlanRequest  $request
     * @param  \App\Models\Plan  $exercice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExerciceRequest $request, $exercice)
    {
    
        if(!$exercice = $this->exerciceService->find($exercice)) {
            return responseRedirect('exercice.index', $this->exerciceService::MSG_NOT_FOUND, 'error');
        }

        if(!$this->exerciceService->save($exercice, requestData($request))) {
            return responseRedirect(['exercice.show', $exercice], $this->exerciceService::MSG_UPDATE_ERROR, 'error');
        } 

        return responseRedirect(['exercice.show', $exercice], $this->exerciceService::MSG_UPDATE_SUCCESS);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $exercice
     * @return \Illuminate\Http\Response
     */
    public function destroy($exercice)
    {
        if(!$exercice = $this->exerciceService->find($exercice)) {
            return responseRedirect('exercice.index',$this->exerciceService::MSG_NOT_FOUND, 'error');
        }

        if(!$this->exerciceService->destroy($exercice)) {
            return responseRedirect('exercice.index', $this->exerciceService::MSG_DELETE_ERROR, 'error');
        } 

        return responseRedirect('exercice.index',$this->exerciceService::MSG_DELETE_SUCCESS);

    }


    public function list()
    {
        $exercices = $this->exerciceService->list();

        foreach($exercices as $i => $exercice) {

            $exercices[$i] = [
                'name'       => anchor(route('exercice.show', $exercice), $exercice->name),
                'status'     => component(new BadgeStatus($exercice->enabled)),
                'type'       => $exercice->typeText,
                'created_at' => $exercice->created_at->format('d/m/Y H:i:s')
            ];
        }

        return responseToDataTable($exercices);
    }
}
