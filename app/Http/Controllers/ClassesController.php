<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Http\Requests\StoreClassesRequest;
use App\Http\Requests\StoreClassPresenceRequest;
use App\Http\Requests\UpdateClassesRequest;
use App\Models\ClassExercice;
use App\Models\Exercice;
use App\Models\Instructor;
use App\Models\Registration;
use App\Services\ClassService;
use App\Services\ExerciceService;
use App\Services\InstructorService;
use App\Services\RegistrationService;
use App\Services\StudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ClassesController extends Controller
{

    protected $request;

    protected $classService;
    protected $registrationService;
    protected $instructorService;
    protected $exerciceService;

    public function __construct(
        Request $request,
        ClassService $classService,
        RegistrationService $registrationService,
        InstructorService $instructorService,
        ExerciceService $exerciceService
    ) {
        $this->request = $request;

        $this->classService        = $classService;
        $this->registrationService = $registrationService;
        $this->instructorService   = $instructorService;
        $this->exerciceService     = $exerciceService;
    }


    public function calendar()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = $this->classService->listToCalendar($request);
            return responseJSON($data);
        }

        $registrations = $this->registrationService->listActiveRegistrations();
        $students      = [];
        foreach ($registrations as $reg) {
            $students[$reg->student_id] = $reg->student->user->name;
        }

        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');

        return view('classes.index', compact('instructors', 'students'));
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
     * @param  \App\Http\Requests\StoreClassesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($studentId, StoreClassesRequest $request, StudentService $studentService)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        if ($request->ajax()) {
            return view('classes.preview', compact('class'))->render();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $class)
    {
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function presence($id)
    {

        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $instructors = $this->toImageSelectBox($this->instructorService->list());
        $exercices   = $this->toSelectBox($this->exerciceService->list());

        return view('classes.presence', compact('class', 'instructors', 'exercices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function absense($id)
    {

        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');

        return view('classes.absense', compact('class', 'instructors'));
    }

    public function evolution($id) {
        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $exercices = $this->toSelectBox(Exercice::all(), 'id', 'name');
        

        return view('classes.evolution', compact('class', 'exercices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function replacement($id)
    {
        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $instructors = $this->toSelectBox($this->instructorService->list(), 'id', 'name');

        return view('classes.replacement', compact('class', 'instructors'));
    }

    public function storeReplacement($id, Request $request)
    {

        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $data = $request->except(['_method', '_token']);

        if (!$this->classService->addReplacement($class, $data)) {
            return responseRedirect('class.index', $this->classService::MSG_REPLACE_ERROR, 'error');
        }

        return responseRedirect('class.index', $this->classService::MSG_REPLACE_SUCCESS);
    }

    public function storeEvolution($id, Request $request) {

        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.evolution', $this->classService::MSG_NOT_FOUND, 'error');
        }

        
        $class->evol()->create([
            'exercice_id' => $request->get('exercice_id'),
            'comments' => $request->get('evolution'),
        ]);


        return responseRedirect(['class.evolution', $class]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClassesRequest  $request
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassesRequest $request, $id)
    {

        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $data = requestData($request);
        
        if (!$this->classService->storeAbsense($class, $data)) {
            return responseRedirect('class.index', $this->classService::MSG_ABSENSE_ERROR, 'error');
        }

        if (isset($data['replace']) && $data['replace'] == 1) {
            return redirect()->route('class.replacement', $class);
        }

        return responseRedirect('class.index', $this->classService::MSG_ABSENSE_SUCCESS);
    }

    public function storePresence(StoreClassPresenceRequest $request, $class)
    {

        if (!$class = $this->classService->find($class)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $this->classService->storePresence($class, $request->except('_token'));

        return responseRedirect('class.index', 'Presença Marcada');
    }

    public function storeAbsense()
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $classes)
    {
        //
    }
}
