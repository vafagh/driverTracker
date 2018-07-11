<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rideable extends Model
{
    public function ride()
    {
        return $this->belongsToMany(Ride::class)->withPivot('created_at', 'updated_at');
    }
    public function trucks()
    {
        return $this->belongsToMany(Truck::class)->withPivot('created_at', 'updated_at');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class)->withPivot('created_at', 'updated_at');
    }
}
