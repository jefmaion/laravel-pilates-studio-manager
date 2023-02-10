<?php

namespace App\Http\Controllers;

use App\Models\Evolution;
use App\Models\Exercice;
use App\Services\ClassService;
use Illuminate\Http\Request;

class EvolutionController extends Controller
{

    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService        = $classService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $exercices = $this->toSelectBox(Exercice::all(), 'id', 'name');
        

        return view('evolution.create', compact('class', 'exercices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        if(!$class->evolution) {
            $evol = Evolution::create([
                'classes_id' => $class->id,
                'student_id' => $class->student_id,
                'instructor_id' => $class->instructor_id,
            ]);
            $class->evolution()->associate($evol);
        }

        $class->evolution->exercices()->create([
            'exercice_id' => $request->get('exercice_id'),
            'comments' => $request->get('comments')
        ]);

        return redirect()->route('evolution.create', $class);

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
    public function destroy($id)
    {
        //
    }
}
