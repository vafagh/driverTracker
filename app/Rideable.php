<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rideable extends Model
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
