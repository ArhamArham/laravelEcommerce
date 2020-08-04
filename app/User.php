<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Role;   
use App\Profile;
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo('\App\Role');
    }
    public function profile()
    {
        return $this->hasOne('\App\Profile');
    }
    public function getCountry()
    {
        return $this->profile->country->name;
    }
    public function getState()
    {
        return $this->profile->state->name;
    }
    public function getCity()
    {
        return $this->profile->city->name;
    }
   
}
