<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Exercice;
use App\Services\ClassService;
use Illuminate\Http\Request;

class ClassesController extends Controller
{

    private $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->list();
        }

        return view('class.index');
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
    public function store(Request $request)
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
        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        return view('class.show', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$class = $this->classService->find($id)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $exercices = $this->toSelectBox(Exercice::all(), 'id', 'name');

        return view('class.edit', compact('class', 'exercices'));
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


    public function list() {

        if(!$classes = $this->classService->list() ) {
            return [];
        }

        $data = [];

        foreach($classes as $i => $class) {

            $data[] = [
                'date'       => sprintf('<a href="%s"> %s</a>', route('class.show', $class) ,$class->date),
                'time'       => $class->time,
                'student'    => '<img alt="image" src="'.imageProfile($class->student->user->image).'" class="rounded-circle" width="45" data-toggle="title" title=""> ' . $class->student->user->name,
                'instructor' => '<img alt="image" src="'.imageProfile($class->instructor->user->image).'" class="rounded-circle" width="45" data-toggle="title" title=""> ' . $class->instructor->user->name,
            ];

        }

        return responseToDataTable($data);
    }
}
