<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'classes_id',
        'registration_id',
        'student_id',
        'instructor_id',
        'scheduled_instructor_id',
        'type',
        'date',
        'time',
        'weekday',
        'status', 
        'comments',
        'class_order',
        'finished'
    ];

   
    public function classRelated() {
        return $this->belongsTo(Classes::class, 'classes_id', 'id');
    }

    public function exercices() {
        return $this->hasMany(ClassExercice::class, 'classes_id', 'id');
    }

    public function getWeekdayNameAttribute() {
        return Config::get('application.weekdays')[$this->weekday];
    }

    public function registration() {
        return $this->belongsTo(Registration::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function evolution() {
        return $this->belongsTo(Evolution::class, 'id','classes_id');
    }

    public function instructor() {
        return $this->belongsTo(Instructor::class);
    }

    public function scheduledInstructor() {
        return $this->belongsTo(Instructor::class, 'scheduled_instructor_id', 'id');
    }

    public function getWeekNameAttribute() {
        $w = Config::get('application.weekdays');
        return $w[$this->weekday];
    }


    public function getClassTypeAttribute() {

        $classTypes = Config::get('application.classTypes');

        return $classTypes[$this->type]['color'];
    }


    public function getStatusClassAttribute() {

        $badge = '<span class="badge badge-pill badge-%s"><span></span> %s</span>';

        $status = Config::get('application.classStatus')[$this->status];
        
        return sprintf($badge, $status['color'], $status['label']);

       
    }

    public function getHasScheduledReplacementClassAttribute() {

        if($this->status === 2 && empty($this->classes_id)) {
            return false;
        }
        
        return true;

    }
}
