<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function states()
    {
        return $this->belongsTo('App\State');
    }
}
