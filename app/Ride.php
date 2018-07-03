<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    // For Deliveries and Pickups
    public function ridable()
    {
        return $this->morghTo();
    }

    public function driver()
    {
        return $this->hasOne('App\Driver');
    }

    public function truck()
    {
        return $this->hasOne('App\Truck');
    }
}
