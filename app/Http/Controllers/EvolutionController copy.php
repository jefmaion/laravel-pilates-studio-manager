<?php

namespace App\Http\Controllers;

use App\Models\Evolution;
use App\Models\EvolutionExercice;
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
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->list();
        }

        return view('evolution.index');
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
        $exercice  = new EvolutionExercice();
        

        return view('evolution.create', compact('class', 'exercices', 'exercice'));
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
    public function edit($idClass, $idExercice)
    {

        

        if (!$class = $this->classService->find($idClass)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $exercice = EvolutionExercice::find($idExercice);

        $exercices = $this->toSelectBox(Exercice::all(), 'id', 'name');
        

        return view('evolution.create', compact('class', 'exercices', 'exercice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idClass, $idExercice)
    {

        if (!$class = $this->classService->find($idClass)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $exercice = EvolutionExercice::find($idExercice);

        $exercice->fill($request->except(['_token', '_method']));

        $exercice->save();

        return redirect()->route('evolution.create', $class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idClass, $idExercice)
    {
        if (!$class = $this->classService->find($idClass)) {
            return responseRedirect('class.index', $this->classService::MSG_NOT_FOUND, 'error');
        }

        $exercice = EvolutionExercice::find($idExercice);

        $exercice->delete();

        return redirect()->route('evolution.create', $class);
    }

    public function list()
    {
        $evolutions = Evolution::all();
        $data = [];
        $imageTag = '<figure class="avatar mr-2 avatar-sm"><img src="%s"></figure>';
        foreach($evolutions as $i => $evol) {
            $data[] = [
                'date' => dateDMY($evol->created_at),
                'student' => sprintf($imageTag, imageProfile($evol->student->user->image)) . $evol->student->user->name,
                'instructor' => sprintf($imageTag, imageProfile($evol->instructor->user->image)) . $evol->instructor->user->name,
            ];
        }

        return responseToDataTable($data);
    }
}
