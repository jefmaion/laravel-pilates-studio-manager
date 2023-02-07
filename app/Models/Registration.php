<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'student_id', 'start', 'end', 'due_date', 'current', 'value', 'discount', 'final_value', 'status', 'cancellation_date', 'cancellation_date', 'cancellation_reason'];
    protected $dates = ['start', 'end'];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function installments() {
        return $this->hasMany(AccountPayable::class);
    }

    public function classes() {
        return $this->hasMany(Classes::class)->orderBy('date');
    }

    public function scheduledClasses() {
        return $this->hasMany(Classes::class)->where('status', 0);
    }

    public function classWeek() {
        return $this->hasMany(RegistrationClass::class);
    }

    public function installmentsToPay() {
        return $this->hasMany(AccountPayable::class)->where('status', 0);
    }
    
    public function getDaysToRenewAttribute() {
        return now()->diffInDays(Carbon::parse($this->end), false);
    }

    public function getDataByWeekday($weekday) {
        if(!$week =  $this->classWeek()->where('weekday', $weekday)->first()) {
            return false;
        }

        return $week;
    }

    


    public function getCanCancelAttribute() {
        return ($this->status == 1 && $this->daysToRenew > 0);
    }

    public function getCanRenewAttribute() {
        return ($this->status == 1 && $this->daysToRenew <= 3);
    }

    public function getStatusRegistrationAttribute() {
        $badge = '<span class="badge badge-pill badge-%s"><span></span> %s</span>';


        if($this->canRenew) {
            return sprintf($badge, 'warning', 'Matrícula a Renovar');
        }
        
        switch ($this->status) {
            case 0:
                return  sprintf($badge, 'light', 'Matrícula Cancelada');
                break;

            case 1:
                return sprintf($badge, 'success', 'Matrícula Em Dia');
                break;

            case 3:
                return sprintf($badge, 'danger', 'Falta');
                break;
            
            case 4:
                return sprintf($badge, 'warning', 'Falta Justificada');
                break;
            
            default:
                # code...
                break;
        }
    }

    public function getRenewPeriodAttribute() {
        $badge = '<span class="badge badge-pill badge-%s"><span></span> %s</span>';

        $endDate = date('Y-m-d', strtotime($this->end));

        $days = Carbon::parse($this->end)->diffForHumans();

        if($endDate == date('Y-m-d')) {
            // return sprintf($badge, 'warning',  'Expira Hoje');
            return "Hoje";
        }

        if($endDate < date('Y-m-d')) {
            // return sprintf($badge, 'danger',  'Expirado');
            return 'Atrasada';
        }

        return $days;

        // if($endDate  > date('Y-m-d')) {
        //     return sprintf($badge, 'success',  $days);
        // }

        // return sprintf($badge, 'success',  $days);
    }
}
