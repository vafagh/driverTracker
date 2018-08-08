<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function rideables()
    {
        return $this->hasMany(Rideable::class);
    }

}
