<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Http\Requests\StoreClassesRequest;
use App\Http\Requests\UpdateClassesRequest;
use App\Models\ClassExercice;
use App\Models\Exercice;
use App\Models\Instructor;
use App\Models\Registration;
use App\Services\ClassService;
use App\Services\InstructorService;
use App\Services\StudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ClassesController extends Controller
{

    protected $request;

    protected $classService;

    public function __construct(Request $request, ClassService $classService)
    {
        $this->request = $request;

        $this->classService = $classService;
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

        
        $registrations = Registration::all();
        $students = [];
        foreach($registrations as $reg) {
            $students[$reg->student_id] = $reg->student->user->name;
        }


        $instructors = $this->toSelectBox(Instructor::all(), 'id', 'name');
     

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

        if(!$class = $this->classService->find($id)) {
            return responseRedirect('plan.index', $this->classService::MSG_NOT_FOUND, 'error');
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

        $class = Classes::find($id);

        $instructors = $this->toSelectBox(Instructor::all(), 'id', 'name');
        $exercices = $this->toSelectBox(Exercice::all(), 'id', 'name');

        return view('classes.presence', compact('class', 'instructors', 'exercices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function absense($id, $status)
    {
        $class       = Classes::find($id);
        $instructors = $this->toSelectBox(Instructor::all(), 'id', 'name');

        return view('classes.absense', compact('class', 'instructors', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function replacement($id)
    {
        $class       = Classes::find($id);
        $instructors = $this->toSelectBox(Instructor::all(), 'id', 'name');

        return view('classes.replacement', compact('class', 'instructors'));
    }

    public function storeReplacement($id, Request $request)
    {

        $class = Classes::find($id);

        $data = $request->except(['_method', '_token']);

        $this->classService->addReplacement($class, $data);

        return responseRedirect('class.index', 'Aula Reagendada');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClassesRequest  $request
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassesRequest $request, Classes $class)
    {


        // dd($request->all());

        $data = [
            'status' => $request->get('status'),
            'comments' => $request->get('comments'),
            'finished' => 1,
            'evolution' => $request->get('evolution')
        ];


        $class->fill($data)->update();

        if($request->get('exercice_id')) {
            $exercices = [];
            foreach($request->get('exercice_id') as $exercice_id) {
                ClassExercice::create([
                    'exercice_id' => $exercice_id,
                    'classes_id' => $class->id
                ]);
                
            }


        }

        if ($request->get('replace')) {
            return redirect()->route('class.replacement', $class);
        }

        return responseRedirect('class.index', 'Presença Marcada');
    }

    private function createReplaceClass($class, $replace)
    {



        $replacementClass = [
            'scheduled_instructor_id' =>  $replace['instructor_id'],
            'weekday' => date('w', strtotime($replace['date'])),
            'type' => 'RP',
            'status' => 0,
            'classes_id' => $class->id,
            'class_order' => $class->order,
            'student_id' => $class->student_id

        ];

        $replacementClass = array_merge($replacementClass, $replace);
        $replacementClass = Classes::create($replacementClass);

        $class->classes_id = $replacementClass->id;
        $class->update();
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
