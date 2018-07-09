<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    public function rideables()
    {
        return $this->belongsToMany(Rideable::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }

    public function trucks()
    {
        return $this->belongsToMany(Truck::class);
    }
}
