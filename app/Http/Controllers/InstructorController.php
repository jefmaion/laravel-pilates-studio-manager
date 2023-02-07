<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Services\InstructorService;
use App\Traits\Viacep;
use App\View\Components\BadgeStatus;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    use Viacep;

    private $instructorService;

    public function __construct(InstructorService $instructorService)
    {
        $this->instructorService = $instructorService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instructor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $instructor = $this->instructorService->new(['enabled' => 1]);
        return  view('instructor.create', compact('instructor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreinstructorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstructorRequest $request)
    {
        $data = requestData($request);

 

        $instructor = $this->instructorService->create($data);

        if($instructor) {
            return responseRedirect(['instructor.show', $instructor], 'Cadastro realizado com sucesso!  (<a href="'.route('instructor.create').'">Adicionar outro Professor</a>)');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show($instructor)
    {

        if(!$instructor = $this->instructorService->find($instructor)) {
            return responseRedirect('instructor.index', 'Registro não encontrado', 'error');
        }

        return view('instructor.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit($instructor)
    {
        if(!$instructor = $this->instructorService->find($instructor)) {
            return responseRedirect('instructor.index', 'Registro não encontrado', 'error');
        }

        return  view('instructor.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateinstructorRequest  $request
     * @param  \App\Models\Plan  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstructorRequest $request, $instructor)
    {
    
        if(!$instructor = $this->instructorService->find($instructor)) {
            return responseRedirect('instructor.index', 'Registro não encontrado', 'error');
        }

        if(!$this->instructorService->save($instructor, requestData($request))) {
            return responseRedirect(['instructor.show', $instructor], 'Não foi possível atualizar o registro', 'error');
        } 

        return responseRedirect(['instructor.show', $instructor], 'Registro Atualizado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy($instructor)
    {
        if(!$instructor = $this->instructorService->find($instructor)) {
            return responseRedirect('instructor.index','Registro não encontrado', 'error');
        }

        if(!$this->instructorService->destroy($instructor)) {
            return responseRedirect('instructor.index', 'Não foi possível excluir o registro', 'error');
        } 

        return responseRedirect('instructor.index','Registro removido com sucesso');

    }


    public function profile($id, Request $request) {


        $instructor = $this->instructorService->find($id);

        if($request->isMethod('get')) {
            return view('instructor.image-profile', compact('instructor'));
        }

        $request->validate([
            'profile_image' => 'required|image',
        ]);
  
        $profileName = time().'.'.$request->profile_image->getClientOriginalExtension();
        $request->profile_image->move(public_path('profiles'), $profileName);

        if($instructor->user->image) {
            if(file_exists(public_path('profiles/' . $instructor->user->image))) {
                unlink(public_path('profiles/' . $instructor->user->image));
            }
        }

        $instructor->user()->update(['image' => $profileName]);
  
        return responseRedirect(['instructor.profile', $instructor],'Foto adicionada com sucesso!');
        
    }


    public function list()
    {
        $instructors = $this->instructorService->list();

        foreach($instructors as $i => $instructor) {

            $user = $instructor->user;

            $instructors[$i] = [
                'name'       =>  sprintf('<a href="%s">%s</a>', route('instructor.show', $instructor), $user->name),
                'status'     => component(new BadgeStatus($instructor->enabled)),
                'profession' => $instructor->profession,
                'phone_wpp'  => $user->phone_wpp,
                'phone2'     => $user->phone2,
                'created_at' => date('d/m/Y', strtotime($instructor->created_at)),
            ];
        }

        return responseToDataTable($instructors);
    }
}
