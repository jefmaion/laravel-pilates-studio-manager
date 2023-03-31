<?php

namespace App\Services;

use App\Models\AccountPayable;
use App\Models\Classes;
use App\Models\Plan;
use App\Models\Registration;
use App\Models\RegistrationClass;
use App\Models\Student;
use Carbon\Carbon;
use Monolog\Registry;

class RegistrationService extends Services {

    const MSG_CANCEL   = 'Registro Cancelado';
    const MSG_UPDATE_CLASSES = 'Aulas reajustadas!';
    const MSG_RENEW_CLASS = 'Não é possível renovar a matrícula! Existem mensalidades a serem pagas!';

    private $classService;
    private $accountPayableService;
    private $planService;
    private $studentService;
   
    public function __construct()
    {
        parent::__construct(new Registration);

        $this->classService          = new ClassService();
        $this->planService           = new PlanService();
        $this->studentService        = new StudentService();
        $this->accountPayableService = new AccountPayable();
    }


    public function makeRegistration($data) {

        $plan    = $this->planService->find($data['plan_id']);
        $student = $this->studentService->find($data['student_id']);

        $data['end']         = date('Y-m-d', strtotime($data['start'] . ' +'.$plan->duration.' months'));
        $data['final_value'] = $data['value'] - ($data['value'] * ($data['discount'] / 100));
        $data['student_id']  = $student->id;
        $data['current']     = 1;
        $data['status']      = 1;

        if(!$registration = $this->create($data)) {
            return false;
        }

        $this->generateInstallments($registration, $data);
        
        if(isset($data['class'])) {
            $this->generateClasses($registration, $data['class']);
        }

        
        return $registration;
    }

    public function renewRegistration(Registration $registration) {
        $registration->start = $registration->end;

        $newRegistration        = $registration->replicate();
        $newRegistration->start =  $registration->end;
        $newRegistration->end   = date('Y-m-d', strtotime($registration->end . ' +'.$registration->plan->duration.' months'));
        $newRegistration->class = $registration->classWeek->toArray();
        $newRegistration->isPaid = 1;

        if($newRegistration = $this->makeRegistration($newRegistration->toArray())) {
            $registration->update(['status' => 2]);
            return $newRegistration;
        }

        return false;
    }

    public function cancelRegistration(Registration $registration, $comments=null, $deleteInstallments=false, $deleteScheduledClasses=false) {

        if($deleteInstallments) {
            $registration->installmentsToPay()->delete();
        }
        
        if($deleteScheduledClasses) {
            $registration->scheduledClasses()->delete();
        }
       
        $this->save($registration, [
            'status'              => 0,
            'current'             => 0,
            'cancellation_date'   => now(),
            'cancellation_reason' => $comments
        ]);
    }

    public function finishRegistration(Registration $registration, $comments=null ) {

        $registration->scheduledClasses()->delete();

        $this->save($registration, [
            'status'              => 2,
            'current'             => 0,
            'cancellation_date'   => now(),
            'cancellation_reason' => $comments
        ]);
    }

    public function updateClassWeek(Registration $registration, $data) {

        $registration->classWeek()->delete();
        $registration->scheduledClasses()->where('type', 'AN')->delete();

        $this->generateClasses($registration, $data, now());

        return true;

    }

    public function generateClasses(Registration $registration, $data, $dateToStart=null, $dateToEnd=null) {

        $dateToStart = (empty($dateToStart)) ? $registration->start : $dateToStart;
        $dateToEnd   = (empty($dateToEnd))   ? $registration->end   : $dateToEnd;
        $numClasses = 0;
        
        foreach($data as  $class) {

            if(empty($class['instructor_id']) || empty($class['time'])) {
                continue;
            }

            $class['registration_id'] = $registration->id;
    
            $newClass  = RegistrationClass::create($class);

            $startDate = (date('w', strtotime($dateToStart)) == $newClass->weekday) ? Carbon::parse($dateToStart) :  Carbon::parse($dateToStart)->next((int) $newClass->weekday); // Get the first friday.
            
            $endDate   = Carbon::parse($dateToEnd);

            

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {

                $this->classService->create([
                        'registration_id' => $registration->id,
                        'student_id' => $registration->student_id,
                        'instructor_id' => $newClass->instructor_id,
                        'scheduled_instructor_id' => $newClass->instructor_id,
                        'type' => 'AN',
                        'date' => $date->format('Y-m-d'),
                        'time' => $newClass->time,
                        'weekday' => $newClass->weekday,
                        'has_replacement' => 1
                ]);

                $numClasses++;
            }
        }

        $classes = Classes::where('registration_id', $registration->id)->orderBy('date', 'asc')->get();
        $order = 1;
        foreach($classes as $class) {
            $class->update(['class_order' => $order]);
            $order++;
        }

        $registration->class_value = $registration->final_value / $numClasses;
        $registration->save();
        
        return true;
    }

    public function addClasses(Registration $registration, $data, $dateToStart=null, $dateToEnd=null) {

        $dateToStart = (empty($dateToStart)) ? $registration->start : $dateToStart;
        $dateToEnd   = (empty($dateToEnd))   ? $registration->end   : $dateToEnd;
        $numClasses = 0;
        
        // foreach($data as  $class) {

            // if(empty($class['instructor_id']) || empty($class['time'])) {
            //     continue;
            // }

            // dd( $data);

            $data['registration_id'] = $registration->id;
    
            $newClass  = RegistrationClass::create($data);

            $startDate = (date('w', strtotime($dateToStart)) == $newClass->weekday) ? Carbon::parse($dateToStart) :  Carbon::parse($dateToStart)->next((int) $newClass->weekday); // Get the first friday.
            
            $endDate   = Carbon::parse($dateToEnd);

            // dd( $startDate);

            for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {

                $this->classService->create([
                        'registration_id' => $registration->id,
                        'student_id' => $registration->student_id,
                        'instructor_id' => $newClass->instructor_id,
                        'scheduled_instructor_id' => $newClass->instructor_id,
                        'type' => 'AN',
                        'date' => $date->format('Y-m-d'),
                        'time' => $newClass->time,
                        'weekday' => $newClass->weekday,
                        'has_replacement' => 1
                ]);

                $numClasses++;
            }
        // }

        $classes = Classes::where('registration_id', $registration->id)->orderBy('date', 'asc')->get();
        $order = 1;
        foreach($classes as $class) {
            $class->update(['class_order' => $order]);
            $order++;
        }

        $registration->class_value = $registration->final_value / $numClasses;
        $registration->save();
        
        return true;
    }

    public function generateInstallments(Registration $registration, $data) {

        $dueDate =  Carbon::parse(date('Y-m-', strtotime($data['start'])) . $data['due_date']) ;

        if(!isset($data['other_payment_method'])) {
            $data['other_payment_method'] = 2;
        }

        if(!isset($data['first_payment_method'])) {
            $data['first_payment_method'] = 1;
        }

        for($i=1; $i<= $registration->plan->duration; $i++) {

            $payDate = null;

            $paymentMethod = $data['other_payment_method'];
            $status = 0;

            if($i === 1) {
                $paymentMethod = $data['first_payment_method'];


                if(isset($data['isPaid'])) {
                    $status = 1;
                    $payDate = $dueDate;
                }

                
            }

            $this->accountPayableService->create([
                'registration_id' => $registration->id,
                'student_id' => $registration->student->id,
                'initial_payment_method_id' => $paymentMethod,
                'payment_method_id' => $paymentMethod,
                'due_date' => $dueDate,
                'pay_date' => $payDate,
                'value' => $registration->final_value,
                'initial_value' => $registration->final_value,
                // 'description' => 'Mensalidade '.$i.'/'.$registration->plan->duration.' de '. $registration->student->user->name,
                'description' => $registration->student->user->name . ' ('.$i.'/'.$registration->plan->duration.')',
                'status' => $status,
                'order' => $i
            ]);

            $dueDate = date('Y-m-d', strtotime($dueDate . ' +1 months'));
            $dueDate =  Carbon::parse(date('Y-m-', strtotime($dueDate)) . $data['due_date']) ;
        }

        return true;

    }

    public function generateClassCalendar(Registration $registration) {


        $calendar    = [];
        $weekClasses = [];

        $classes = RegistrationClass::whereHas('registration', function($query) {
            $query->where('status', 1);
        })->get();

    
        foreach($classes as $class) {
            $student = '<span class="text-muted mbs-2">' .  $class->registration->student->name . '</span>';
            if($class->registration->student_id == $registration->student_id) {
                $student = '<span class="badge badge-pill badge-primary msb-2">'.$class->registration->student->name.'</span>';
            }

            $weekClasses[$class->time][$class->weekday][] = $student;
        }

        $calendar['weekdays'] = appConfig('weekdays');
        foreach(appConfig('class_time') as $t => $time) {
            foreach(appConfig('weekdays') as $w => $weekday) {
                $calendar['classes'][$t][$w] = isset($weekClasses[$t][$w]) ? '<div>' . implode("</div><div>", $weekClasses[$t][$w]) . '</div>' : null ;
            }
        }

        return $calendar;

    }

    public function removeRegistrationClass(Registration $registration, $idClass = 0) {
        $class =  RegistrationClass::find($idClass);

        $registration->classes()->where('type', 'AN')->where('status', 0)->where('weekday', $class->weekday)->where('time', $class->time)->delete();
        $registration->classWeek()->where('id', $idClass)->delete();
    }

    public function listActiveRegistrations() {
        return Registration::where('status', 1)->orderBy('created_at', 'desc')->get();
    }

    public function countActiveRegistrations() {
        return Registration::where('status', 1)->count();
    }

    public function countRenewRegistrations() {
        return Registration::where('status', 1)->where('end', '<=', Carbon::now()->subDays(5)->toDateTimeString())->count();
    }


}

// $classes = RegistrationClass::select('weekday', 'time', DB::raw("count(registration_id) as total"))->groupBy('weekday', 'time')->get();