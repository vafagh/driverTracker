<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function fillups()
    {
        return $this->hasMany(Fillup::class);
    }

}
