<?php

namespace App\Services;

use App\Models\Classes;

class ClassService extends Services {

    protected $plan;
   
    public function __construct()
    {
        parent::__construct(new Classes);
    }


    public function addReplacement(Classes $class, $replace) {
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


}