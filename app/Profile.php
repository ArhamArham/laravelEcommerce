<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Profile extends Model
{
    //
    protected $guarded=[];
    use SoftDeletes;
    //Softdeletes
    protected $dates=['deleted_at'];
    public function user()
    {
        return $this->belongsTo('\App\User');
    }
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    public function state()
    {
        return $this->belongsTo('App\State');
    }
    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
