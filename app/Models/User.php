<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        'nickname',
        'cpf',
        'zipcode',
        'gender',
        'birth_date',
        'address',
        'complement',
        'number',
        'city',
        'state',
        'district',
        'phone_wpp',
        'phone2',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function getNicknameAttribute() {
    //     $nickname = $this->nickname;

    //     // if(empty($nickname)) {
    //     //     $name = explode(" ", $this->name);
    //     //     $nickname = $name[0];
    //     // }

    //     return $nickname;
    // }

    public function getAgeAttribute() {
        return Carbon::parse($this->birth_date)->age;
    }
}
