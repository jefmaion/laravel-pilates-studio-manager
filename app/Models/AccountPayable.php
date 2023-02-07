<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPayable extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'registration_id',
        'student_id',
    'due_date',
    'value',
    'description','
    status', 'order'];


    public function getStatusLabelAttribute() {
        $badge = '<span class="badge badge-pill badge-%s"><span></span> %s</span>';

        $dueDate = date('d/m/Y', strtotime($this->due_date));

        if($this->status == 1) {
            return sprintf($badge, 'success',  'Pago');
        }

        if($this->due_date == date('Y-m-d')) {
            return sprintf($badge, 'warning',  'Pagar Hoje');
        }

        if($this->due_date > date('Y-m-d')) {
            return sprintf($badge, 'light',  'Aberto');
        }

        if($this->due_date < date('Y-m-d') && $this->status == 0) {
            return sprintf($badge,   'danger',  'Atrasada');
        }

    }
}
