<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationClassRequest;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\RegistrationClass;
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class RegistrationClassController extends Controller
{

    private $request;
    private $registrationService;
    private $studentService;
    private $instructorService;
    private $planService;


    public function __construct(
        RegistrationService $registrationService
    )
    {
        $this->registrationService = $registrationService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        };

        $instructors = $this->toImageSelectBox(Instructor::all());

        // if($request->isMethod('post')) {
        //     $this->registrationService->addClasses($registration, $request->all());
        //     return redirect()->route('registration.classes', $registration);
        // }

        $classes = RegistrationClass::all();

        $calendar = [];
        $weekClasses = [];

        foreach($classes as $class) {

            $student = '<span class="badge badge-pill badge-light mb-2">' .  $class->registration->student->name . '</span>';

            if($class->registration->student_id == $registration->student_id) {
                $student = '<span class="badge badge-pill badge-primary mb-2">'.$class->registration->student->name.'</span>';
            }

            $weekClasses[$class->time][$class->weekday][] = $student;
        }

        $calendar['weekdays'] = appConfig('weekdays');
        foreach(appConfig('class_time') as $t => $time) {
            foreach(appConfig('weekdays') as $w => $weekday) {




                $calendar['classes'][$time][] = isset($weekClasses[$t][$w]) ? '<div>' . implode("</div><div>", $weekClasses[$t][$w]) . '</div>' : null ;
            }
        }
        
        
      
        
        return view('registration.class', compact('registration', 'instructors', 'calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistrationClassRequest $request, $id)
    {

        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        };

        $this->registrationService->addClasses($registration, $request->all());
        return redirect()->route('registration.class.index', $registration);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $idClass)
    {

        $registration = Registration::find($id);
        $class       =  RegistrationClass::find($idClass);

        $registration->classes()->where('type', 'AN')->where('status', 0)->where('weekday', $class->weekday)->where('time', $class->time)->delete();
        $registration->classWeek()->where('id', $idClass)->delete();

        return redirect()->route('registration.class.index', $registration);
    }
}
