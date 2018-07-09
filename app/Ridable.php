<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ridable extends Model
{
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
}
