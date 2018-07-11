<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function rideables()
    {
        return $this->belongsToMany(Rideable::class)->withPivot('created_at', 'updated_at');
    }
    public function drivers()
    {
        return $this->belongsToMany(Driver::class)->withPivot('created_at', 'updated_at');
    }
}
