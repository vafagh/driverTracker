<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public function rideables()
    {
        return $this->belongsToMany(Rideable::class)->withPivot('created_at', 'updated_at');
    }

}
