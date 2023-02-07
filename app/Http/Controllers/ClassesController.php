<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Http\Requests\StoreClassesRequest;
use App\Http\Requests\UpdateClassesRequest;
use App\Models\ClassExercice;
use App\Models\Exercice;
use App\Models\Instructor;
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

            


            $start = Carbon::parse($request->query('start'));
            $end   = Carbon::parse($request->query('end'));

          

            $color = [
                1 => 'info',
                2 => 'success',
                3 => 'warning',
                4 => 'danger'
            ];

            $icons = [
                1 => '<i class="fa fa-circle fa-xs" aria-hidden="true"></i>',
                2 => '<i class="far fa-check-circle fa-xs" aria-hidden="true"></i>',
                3 => '<i class="far fa-times-circle fa-xs text-danger" aria-hidden="true"></i>',
                4 => '<i class="far fa-times-circle fa-xs" aria-hidden="true"></i>'
            ];

            $params = $request->except(['_', 'start', 'end']);

            $classes = Classes::whereBetween('date', [$start, $end]);

            foreach($params as $key => $value) {
                if(empty($value)) continue;
                $classes->where($key, $value);
            }

            $classes = $classes->get();




            $calendar = [];
            foreach ($classes as $class) {

                $icon = '';
                $bg   = Config::get('application.classStatus')[$class->status]['color'];

                if(!$class->hasScheduledReplacementClass) {
                    $icon = '<i class="fa fa-exclamation-circle fa-sm text-danger m-1" aria-hidden="true"></i>';
                }

                $badge =  '<span class=" badge badge-secondary p-0 px-1"><small><b> ' .  $class->type . '</b></small></span> ';

                $time = $class->time;
                $time = date('H:i', strtotime($time . '+1 hour'));
                $calendar[] = [
                    'id' => $class->id,
                    // 'title'     =>   '' . $badge . '<span><b>' . $class->student->user->nickname . '</b></span>',
                    'title' => '<div class="h6 m-0 ">'. $badge .'<b>'  . $class->student->user->nickname . '</b> </div>
                                <div>'. $icon . $class->instructor->user->nickname.'</div>',

                    'start'     => $class->date .  'T' . $class->time,
                    'end'       => $class->date .  'T' . $time,
                    'className' => ['bg-' . $bg],


                    // 'backgroundColor' => "#00bcd4"
                    // 'borderColor' => '#00000'
                ];
            }

            return responseJSON($calendar);
        }

        

        $instructors = $this->toSelectBox(Instructor::all(), 'id', 'name');

        return view('classes.index', compact('instructors'));
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


        $student = $studentService->find($studentId);
        $data = $request->all();


        $fridays = [];
        $startDate = Carbon::parse($student->registration->start)->next((int) $data['weekday']); // Get the first friday.
        $endDate = Carbon::parse($student->registration->end);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $fridays[] = $date->format('Y-m-d');
            Classes::create([
                // 'classes_id' => '',,
                'registration_id' => $student->registration->id,
                'student_id' => $student->id,
                'instructor_id' => $data['instructor_id'],
                'scheduled_instructor_id' => $data['instructor_id'],
                'type' => 'AN',
                'date' => $date->format('Y-m-d'),
                'time' => $data['time'],
                'weekday' => $data['weekday'],
                'status' => 1
            ]);
        }

        return redirect(route('class.index', $student) . '#classes');
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

        return view('classes.presence', compact('class', 'instructors', 'exercices', 'ue'));
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
