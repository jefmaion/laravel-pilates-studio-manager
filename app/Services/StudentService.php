<?php

namespace App\Services;

use App\Libraries\FileManager;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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

    public function saveProfilePhoto(Student $student, $file) {

        $profileFolder = Config::get('application.imgProfileFolder');

        FileManager::path($profileFolder);

        if(!$fileName = FileManager::saveImage($file)) {
            return false;
        }

        if($student->user->image) {
            FileManager::destroy($student->user->image);
        }

        return $student->user()->update(['image' => $fileName]);
    }

    public function listAllNotRegistrations() {
        return $this->student->doesntHave("registration")->get();
    }



}