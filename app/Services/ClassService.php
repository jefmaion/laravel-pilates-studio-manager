<?php

namespace App\Services;

use App\Models\Classes;
use App\Models\ClassExercice;
use App\Models\Evolution;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class ClassService extends Services
{

    const MSG_REPLACE_SUCCESS   = 'Reposição reagendada com sucesso!';
    const MSG_REPLACE_ERROR   = 'Não foi possível reagendar';

    const MSG_ABSENSE_SUCCESS   = 'Falta registrada com sucesso!';
    const MSG_ABSENSE_ERROR   = 'Não foi possível registrar a falta';

    protected $plan;

    public function __construct()
    {
        parent::__construct(new Classes);
    }


    public function addReplacement(Classes $class, $replace)
    {

        $newClass = $class->replicate();

        $newClass->fill($replace);
        $newClass->type                    = 'RP';
        $newClass->status                  = 0;
        $newClass->finished                = 0;
        $newClass->weekday                 = date('w', strtotime($replace['date']));
        $newClass->scheduled_instructor_id = $newClass->instructor_id;

        $newClass->classRelated()->associate($class);
        $newClass->save();

        $class->classRelated()->associate($newClass);

        if($class->update()) {
            return true;
        }

        return false;
    }


    public function storePresence(Classes $class, $data) {

        $class->fill($data)->update();

    
        if(isset($data['evolution'])) {
            Evolution::create([
                'instructor_id' => $class->instructor_id,
                'classes_id' => $class->id,
                'evolution' => $data['evolution']
            ]);
        }

        if(isset($data['exercice_id'])) {
            foreach($data['exercice_id'] as $exercice_id) {
                ClassExercice::create([
                    'exercice_id' => $exercice_id,
                    'classes_id' => $class->id
                ]);            
            }
        }
        return true;
        
    }

    public function storeAbsense(Classes $class, $data) {
        
        $class->finished = 1;

        if($class->fill($data)->update()) {
            return true;
        }

        return false;

    }


    public function listToCalendar($request)
    {

        $start = Carbon::parse($request->query('start'));
        $end   = Carbon::parse($request->query('end'));


        $params = $request->except(['_', 'start', 'end']);

        $classes = Classes::whereBetween('date', [$start, $end]);

        foreach ($params as $key => $value) {
            if ($value == "") continue;
            $classes->where($key, $value);
        }

        $classes = $classes->get();
        $calendar = [];


        foreach ($classes as $class) {

            $icon = '';
            $bg   = Config::get('application.classStatus')[$class->status]['color'];

            if (!$class->hasScheduledReplacementClass) {
                $icon = '<i class="fa fa-exclamation-circle fa-lg text-danger m-1" aria-hidden="true"></i>';
            }

            if ($class->status ==1 && !$class->evolution) {
                $icon = '<i class="fa fa-exclamation-circle fa-lg text-danger m-1" aria-hidden="true"></i>';
            }

            if ($class->student->hasLateInstallments) {
                $icon = '<span class="text-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>';
            }

            $badge =  '<span class=" badge badge-secondary p-0 px-1">
                        <small>
                            <b>' .  $class->type . '</b>
                        </small>
                    </span> ';

            $badge = '';

            $time  = $class->time;
            $time  = date('H:i', strtotime($time . '+1 hour'));
            $title = '<div class="m-0 ">
                        '. $icon  . $badge . 
                        '<b>'  . $class->student->user->nickname . '</b> 
                      </div>
                      <div>
                      '.appConfig('classTypes')[$class->type]['label'].'
                      </div>';

            $calendar[] = [
                'id' => $class->id,
                'title' => $title,
                'start'     => $class->date .  'T' . $class->time,
                'end'       => $class->date .  'T' . $time,
                'className' => ['bg-' . $bg],
            ];
        }

        return $calendar;
    }
}
