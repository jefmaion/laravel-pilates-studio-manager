<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfilePhotoRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\InstructorService;
use App\Services\PlanService;
use App\Services\StudentService;
use App\Traits\Viacep;
use App\View\Components\BadgeStatus;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    use Viacep;

    private $request;
    private $studentService;

    public function __construct(Request $request, StudentService $studentService)
    {
        $this->studentService = $studentService;
        $this->request = $request;
    }

    public function index()
    {
        if($this->request->ajax()) {
            return $this->list();
        }

        return view('student.index');
    }

    public function create()
    {
        $student = $this->studentService->new(['enabled' => 1]);
        return  view('student.create', compact('student'));
    }

    public function store(StoreStudentRequest $request)
    {
        $data = requestData($request);

        $student = $this->studentService->create($data);

        if($student) {
            return responseRedirect(['student.show', $student], $this->studentService::MSG_CREATE_SUCCESS);
        } 
    }

    public function show($student, PlanService $planService, InstructorService $instructorService)
    {

        if(!$student = $this->studentService->find($student)) {
            return responseRedirect('student.index', $this->studentService::MSG_NOT_FOUND, 'error');
        }

        return view('student.show', compact('student'));
    }

    public function edit($student)
    {
        if(!$student = $this->studentService->find($student)) {
            return responseRedirect('student.index', $this->studentService::MSG_NOT_FOUND, 'error');
        }

        return  view('student.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, $student)
    {
    
        if(!$student = $this->studentService->find($student)) {
            return responseRedirect('student.index', $this->studentService::MSG_NOT_FOUND, 'error');
        }

        if(!$this->studentService->save($student, requestData($request))) {
            return responseRedirect(['student.show', $student], $this->studentService::MSG_UPDATE_ERROR, 'error');
        } 

        return responseRedirect(['student.show', $student], $this->studentService::MSG_UPDATE_SUCCESS);

    }

    public function destroy($student)
    {
        if(!$student = $this->studentService->find($student)) {
            return responseRedirect('student.index',$this->studentService::MSG_NOT_FOUND, 'error');
        }

        if(!$this->studentService->destroy($student)) {
            return responseRedirect('student.index', $this->studentService::MSG_DELETE_ERROR, 'error');
        } 

        return responseRedirect('student.index',$this->studentService::MSG_DELETE_SUCCESS);

    }

    public function profile(StoreProfilePhotoRequest $request, $id) {

        $student = $this->studentService->find($id);

        if($request->isMethod('get')) {
            return view('student.image-profile', compact('student'));
        }

        if(!$this->studentService->saveProfilePhoto($student, $request->profile_image)) {
            return responseRedirect(['student.profile', $student],'Erro ao salvar', 'error');
        }

        return responseRedirect(['student.show', $student],'Foto adicionada com sucesso!');
        
    }


    public function list()
    {
        $students = $this->studentService->listOrderByCreatedAt();

        foreach($students as $i => $student) {

            $user = $student->user;


            $students[$i] = [
                'image'      =>'<img alt="image" src="'.imageProfile($student->user->image).'" class="rounded-circle" width="45" data-toggle="title" title="">',
                'name'       =>  sprintf('<a href="%s"> %s</a>', route('student.show', $student), $user->name),
                'phone_wpp'  => $user->phone_wpp,
                'phone2'     => $user->phone2,
                'created_at' => date('d/m/Y', strtotime($student->created_at)),
                'status'     => component(new BadgeStatus($student->enabled)),
            ];
        }

        return responseToDataTable($students);
    }
}
