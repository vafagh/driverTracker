<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function ride()
    {
        return $this->belongsToMany('App\Ride');
    }
}
