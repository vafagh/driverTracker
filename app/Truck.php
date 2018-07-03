<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function ride()
    {
        return $this->belongsToMany('App\Ride');
    }
}
