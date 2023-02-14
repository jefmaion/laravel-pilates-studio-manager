<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Instructor;
use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\Student;
use App\Services\InstructorService;
use App\Services\PlanService;
use App\Services\RegistrationService;
use App\Services\StudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RegistrationController extends Controller
{

    private $request;
    private $registrationService;
    private $studentService;
    private $instructorService;
    private $planService;


    public function __construct(
        Request $request, 
        StudentService $studentService, 
        PlanService $planService, 
        RegistrationService $registrationService, 
        InstructorService $instructorService
    )
    {
        $this->request             = $request;
        $this->studentService      =  $studentService;
        $this->planService         = $planService;
        $this->registrationService = $registrationService;
        $this->instructorService   = $instructorService;
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

        return view('registration.index');
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $students    = $this->toSelectBox($this->studentService->list(), 'id', 'name');
        $plans       = $this->toSelectBox($this->planService->list(), 'id', 'name');
        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');
        $paymentMethods = $this->toSelectBox(PaymentMethod::all(), 'id', 'name');

        return view('registration.create', compact('students', 'plans', 'instructors', 'paymentMethods'));
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

        $registration = $this->registrationService->makeRegistration($data);

        if($registration) {
            return responseRedirect(['registration.show', $registration], $this->registrationService::MSG_CREATE_SUCCESS . ' (<a href="'.route('registration.create').'">Matricular Outro</a>)');
        } 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        }

        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');
        return view('registration.show', compact('registration', 'instructors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        // if($registration->scheduledClasses()->count() > 0) {
        //     return responseRedirect(['registration.show', $registration], $this->registrationService::MSG_RENEW_CLASS, 'warning');
        // }

        $students    = $this->toSelectBox($this->studentService->list(), 'id', 'name');
        $plans       = $this->toSelectBox($this->planService->list(), 'id', 'name');
        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');

        return view('registration.edit', compact('students', 'plans', 'instructors', 'registration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegistrationRequest  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        }



        $this->registrationService->updateClassWeek($registration, $request->get('class'));

        return responseRedirect(['registration.show', $registration], $this->registrationService::MSG_UPDATE_CLASSES);
    }

    public function classes(Request $request, $id) {





        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        };

        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');


        if($request->isMethod('post')) {
            $this->registrationService->addClasses($registration, $request->all());
            return redirect()->route('registration.classes', $registration);
        }

        
        return view('registration.class', compact('registration', 'instructors'));
    }

    public function renew($id) {

        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        };


        $new = $registration->replicate();

        $new->start = $registration->end;
        $new->first_payment_method = 1;
        $new->other_payment_method = 1;
        $new->class = $registration->classWeek->toArray();

        $registration->update(['status' => 2]);
        

        $registration = $this->registrationService->makeRegistration($new->toArray());

        if($registration) {
            return responseRedirect(['registration.show', $registration], $this->registrationService::MSG_CREATE_SUCCESS . ' (<a href="'.route('registration.create').'">Matricular Outro</a>)');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {

        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        }

        $this->registrationService->cancelRegistration($registration,  $request->get('cancellation_reason'));
        return responseRedirect('registration.index', $this->registrationService::MSG_CANCEL);
    }

    public function list() {

        if(!$registrations = $this->registrationService->listActiveRegistrations() ) {
            return [];
        }

        $data = [];

        foreach($registrations as $i => $registration) {

            $user = $registration->student->user;

            $data[] = [
                'student' =>  sprintf('<a href="%s"><img alt="image" src="'.imageProfile($user->image).'" class="rounded-circle" width="45" data-toggle="title" title=""> %s</a>', route('registration.show', $registration), $user->name),
                'phone'   => $user->phone_wpp,
                'status'  => $registration->statusRegistration,
                'renew'   => $registration->renewPeriod,
                'end'     => date('d/m/Y', strtotime($registration->end)),
                'value'   => 'R$ '. USD_BRL($registration->final_value)
            ];

        }

        return responseToDataTable($data);
    }



















    
    public function __seederRegistrations() {
        $students = Student::limit(40)->get();
        $plans    = Plan::all();
        $instructors = Instructor::limit(3)->get();
        $registration = new RegistrationService();
        $payments = PaymentMethod::all();

        $times = [];
        foreach(Config::get('application.class_time') as $key => $item) {
            $times[] = $key;
        }


        $regs = [];

        foreach($students as $student) {

            $plan = $plans[rand(0, count($plans)-1)];
            $pay1 = $plans[rand(0, count($payments)-1)];
            $pay2 = $plans[rand(0, count($payments)-1)];
            $start = date('Y-m-d', strtotime(Carbon::parse('2023-01-01')->addDays(rand(1, 365))));

            $data = [];
            $data['plan_id']     = $plan->id;
            $data['student_id']  = $student->id;
            $data['start']       = $start;
            $data['value']       = $plan->value;
            $data['due_date']    = rand(1,28);
            $data['discount']    = rand(1,5);
            $data['end']         = date('Y-m-d', strtotime($data['start'] . ' +'.$plan->duration.' months'));
            $data['final_value'] = $data['value'] - ($data['value'] * ($data['discount'] / 100));
            $data['current']     = 1;
            $data['status']      = 1;

            $data['first_payment_method'] = $pay1->id;
            $data['other_payment_method'] = $pay2->id;


            $reg = $registration->makeRegistration($data);

            $classes = [];

            for($i=0;$i<=$plan->class_per_week; $i++) {
                $registration->addClasses($reg, [
                    'instructor_id' => $instructors[rand(0, count($instructors)-1)]->id,
                    'weekday'   => rand(1,6),
                    'time'  => $times[rand(0, count($times)-1)]
                ]);
            }

    
            
           
        }
    }
}
