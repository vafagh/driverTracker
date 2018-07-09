<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ridable extends Model
{
    public function rides()
    {
        return $this->belongsToMany(Ride::class,'rides');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
}
