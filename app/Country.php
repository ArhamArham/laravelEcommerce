<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    public function states()
    {
        return $this->hasOne('App\State');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasOneThrough('App\City','App\State');
    }
}
