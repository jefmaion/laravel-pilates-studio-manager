<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationClassRequest;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\RegistrationClass;
use App\Services\InstructorService;
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
        RegistrationService $registrationService,
        InstructorService $instructorService
    )
    {
        $this->registrationService = $registrationService;
        $this->instructorService = $instructorService;
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

        $instructors = $this->toImageSelectBox($this->instructorService->listEnabled());
        $calendar    = $this->registrationService->generateClassCalendar($registration);
        
        return view('registration.class', compact('registration', 'instructors', 'calendar'));
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $idClass)
    {

        if(!$registration = $this->registrationService->find($id)) {
            return responseRedirect('registration.index', $this->registrationService::MSG_NOT_FOUND, 'error');
        };

        $this->registrationService->removeRegistrationClass($registration, $idClass);

        return redirect()->route('registration.class.index', $registration);
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

    
}
