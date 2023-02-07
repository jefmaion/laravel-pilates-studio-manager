<?php

namespace App\Services;


use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StudentService extends Services {

    protected $student;
    protected $user;
   
    public function __construct()
    {
        parent::__construct(new Student());

        $this->student = new Student();
        $this->user    = new User();
    }

    public function new($attr=null) {

        $student = new Student(['enabled' => 1]);
        $student->user = new User();

        return $student;
    }


    public function create($data) {
        
        $user = $this->user->create($data);

        if(empty($user)) {
            return false;
        }

        $student = new Student();
        $student->user()->associate($user);

        if($student->save()) {
            return $student;
        }

        return false;
    }

    public function save(Model $item, $data) {
        
        $item->fill($data);
        $item->user->fill($data);

        if($item->push()) {
            return true;
        }

        return false;

    }



}