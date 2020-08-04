<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;
class State extends Model
{
    //
  /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->hasOne('App\Country');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
