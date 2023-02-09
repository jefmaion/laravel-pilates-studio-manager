<?php

namespace App\Services;

use App\Libraries\FileManager;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class InstructorService extends Services {

    protected $instructor;
    protected $user;
   
    public function __construct(Instructor $instructor, User $user)
    {
        parent::__construct($instructor);

        $this->instructor = $instructor;
        $this->user    = $user;
    }

    public function new($attr=null) {

        $instructor = new Instructor(['enabled' => 1]);
        $instructor->user = new User();

        return $instructor;
    }


    public function create($data) {
        
        $user = $this->user->create($data);

        if(empty($user)) {
            return false;
        }

        $instructor = new Instructor();
        $instructor->user()->associate($user);

        $instructor->fill($data);

        if($instructor->save()) {
            return $instructor;
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

    public function saveProfilePhoto(Instructor $instructor, $file) {

        $profileFolder = Config::get('application.imgProfileFolder');

        FileManager::path($profileFolder);

        if(!$fileName = FileManager::saveImage($file)) {
            return false;
        }

        if($instructor->user->image) {
            FileManager::destroy($instructor->user->image);
        }

        return $instructor->user()->update(['image' => $fileName]);
    }



}