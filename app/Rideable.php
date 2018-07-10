<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rideable extends Model
{
    public function trucks()
    {
        return $this->belongsToMany(Truck::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
}
