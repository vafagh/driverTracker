<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function rides()
    {
        return $this->belongsToMany(Ride::class);
    }

    public function attach(Driver $driver)
    {
        $driver->trucks()->attach();
    }
}
