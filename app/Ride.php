<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    public function ridables()
    {
        return $this->belongsToMany(Ridable::class);
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
