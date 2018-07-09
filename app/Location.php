<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public function Rideables()
    {
        return $this->belongsToMany(Rideable::class);
    }

}
