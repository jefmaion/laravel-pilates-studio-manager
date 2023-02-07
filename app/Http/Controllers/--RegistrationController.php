<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Models\AccountPayable;
use App\Services\PlanService;
use App\Services\StudentService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    protected $studentId;
    protected $student;

    protected $planService;
    protected $studentService;

    public function __construct(Request $request, PlanService $planService, StudentService $studentService)
    {
        $this->studentId      = $request->segment(2);        
        $this->planService    = $planService;
        $this->studentService = $studentService;

        $this->student = $this->studentService->find($request->segment(2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $student = $this->student;
        $listPLans = $this->planService->list(1);
        $plans     = [];

        foreach($listPLans as $key => $item) {
            $plans[$item->id] = $item->name . ' (R$ '.USD_BRL($item->value).')';
        }

        return view('student.registration', compact('student', 'plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $student = $this->studentService->find($this->studentId);

        $listPLans = $this->planService->list(1);
        $plans     = [];

        foreach($listPLans as $key => $item) {
            $plans[$item->id] = $item->name . ' (R$ '.USD_BRL($item->value).')';
        }

        return view('registration.create', compact('student', 'plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistrationRequest $request)
    {
        $data = requestData($request);

        $data['value'] =  BRL_USD($data['value']);

        $plan    = $this->planService->find($data['plan_id']);
        $student = $this->studentService->find($this->studentId);


        $data['end'] = date('Y-m-d', strtotime($data['start'] . ' +'.$plan->duration.' months'));
        $data['final_value']      = $data['value'] - ($data['value'] * ($data['discount'] / 100));
        $data['student_id']       = $student->id;
        $data['current']          = 1;

        if(!$registration = Registration::create($data)) {
            return responseRedirect(['student.show', $student], 'Não foi possível realizar a matricula', 'error');
        }

        $dueDate = $data['start'];

        for($i=1; $i<= $plan->duration; $i++) {

            AccountPayable::create([
                'registration_id' => $registration->id,
                'student_id' => $student->id,
                'due_date' => $dueDate,
                'value' => $registration->final_value,
                'description' => 'Mensalidade '.$i.'/'.$plan->duration.' de '. $student->user->name,
                'status' => ($i === 1) ? 1 : 0
            ]);

            $dueDate = date('Y-m-d', strtotime($dueDate . ' +1 months'));
        }

        return responseRedirect(['registration.index', $student], 'Matrícula Realizada com Sucesso');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegistrationRequest  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Registration $registration)
    {
        
        $registration->installmentsToPay()->delete();
        $registration->classes()->delete();
        $registration->delete();
        return responseRedirect(['registration.index', $this->studentService->find($id)], 'Matrícula Removida com Sucesso');
    }
}
