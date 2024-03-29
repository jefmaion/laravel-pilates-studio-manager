<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comments',
        'enabled'
    ];

    public function getNameAttribute() {
        return $this->user->name;
    }

    public function getImageAttribute() {
        return $this->user->image;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function registration() {
        return $this->hasOne(Registration::class)->where('current', 1);
    }

    public function registrations() {
        return $this->hasMany(Registration::class);
    }

    public function installments() {
        return $this->hasMany(AccountPayable::class);
    }

    public function classes() {
        return $this->hasMany(Classes::class);
    }

    public function classesFinished() {
        return $this->classes()->where('status', 1);
    }

    public function evolutions() {
        return $this->classes()->whereNotNull('evolution');
    }

    public function getLastClassesAttribute() {
        // return $this->evolutions()->where('finished', 1)->orderBy('date', 'desc')->get();
        return $this->classes()->where('finished', 1)->orderBy('date', 'DESC')->limit(3)->get();
    }

    public function lastEvolution() {
       return $this->classes()->where('status', 1)->orderBy('date', 'DESC')->first();
    }

    public function getLastClassAttribute() {
        return $this->lastEvolution();
    }

    public function getLastEvolAttribute() {
       $ev = $this->classes()->where('status', 1)->orderBy('date', 'DESC')->first();

       return $ev;
    }

    public function getHasLateInstallmentsAttribute() {
        return $this->installments()->where('status', 0)->whereDate('due_date', '<', Carbon::now())->count();
    }

    public function getHasInstallmentsToPayTodayAttribute() {
        return $this->installments()->where('status', 0)->whereDate('due_date', '=', Carbon::now())->count();
    }


    public function getStatusAttribute() {
        $badge = '<span class="badge badge-pill badge-%s"><span></span> %s</span>';


        if(!isset($this->registration)) {
            return sprintf($badge, 'light',  '-');
        }

        // $days = now()->diffInDays(Carbon::parse($this->registration->end_registration));
     
        // $days = now()->diffInDays(Carbon::parse($this->registration->end_registration));
        // if($days < 2) {
        //     return sprintf($badge, 'danger',  'Vencerá em ' .  (($days) ). ' dias');
        // }

        if(date('Y-m-d') < $this->registration->end_registration) {
            return sprintf($badge, 'success',  'Matriculado');
        }

        if(date('Y-m-d') == $this->registration->end_registration) {
            return sprintf($badge, 'warning',  'Vence Hoje');
        }

        

       

        

        

       

        

       
    }
}
