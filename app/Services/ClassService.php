<?php

namespace App\Services;

use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class ClassService extends Services
{

    protected $plan;

    public function __construct()
    {
        parent::__construct(new Classes);
    }


    public function addReplacement(Classes $class, $replace)
    {
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


    public function listToCalendar($request)
    {

        $start = Carbon::parse($request->query('start'));
        $end   = Carbon::parse($request->query('end'));



        $color = [
            1 => 'info',
            2 => 'success',
            3 => 'warning',
            4 => 'danger'
        ];

        $icons = [
            1 => '<i class="fa fa-circle fa-xs" aria-hidden="true"></i>',
            2 => '<i class="far fa-check-circle fa-xs" aria-hidden="true"></i>',
            3 => '<i class="far fa-times-circle fa-xs text-danger" aria-hidden="true"></i>',
            4 => '<i class="far fa-times-circle fa-xs" aria-hidden="true"></i>'
        ];

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
                $icon = '<i class="fa fa-exclamation-circle fa-sm text-danger m-1" aria-hidden="true"></i>';
            }

            $badge =  '<span class=" badge badge-secondary p-0 px-1"><small><b> ' .  $class->type . '</b></small></span> ';

            $time = $class->time;
            $time = date('H:i', strtotime($time . '+1 hour'));
            $calendar[] = [
                'id' => $class->id,
                'title' => '<div class="m-0 ">' . $badge . '<b>'  . $class->student->user->nickname . '</b> </div>
                                <div>' . $icon . $class->instructor->user->nickname . '</div>',

                'start'     => $class->date .  'T' . $class->time,
                'end'       => $class->date .  'T' . $time,
                'className' => ['bg-' . $bg],
                // 'backgroundColor' => "#00bcd4"
                // 'borderColor' => '#00000'
            ];
        }

        return $calendar;
    }
}
