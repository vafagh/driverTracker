<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function rides()
    {
        return $this->belongsToMany(Ride::class);
    }
    // public function trucks()
    // {
    //     return $this->hasOne(Truck::class);
    // }
}
