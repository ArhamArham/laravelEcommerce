<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Payment extends Model
{
    //
    use SoftDeletes;
    protected $guarded=[];
    //Softdeletes
    protected $dates=['deleted_at'];
}
