<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function rideables()
    {
        return $this->belongsToMany(Rideable::class);
    }
    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }
}
