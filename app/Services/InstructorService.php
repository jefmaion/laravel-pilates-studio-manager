<?php

namespace App\Services;

use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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



}