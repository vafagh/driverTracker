<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function fillups()
    {
        return $this->hasMany(Fillup::class);
    }

    public function totalDistance()
    {
        return Ride::where('driver_id', $this->id)->sum('distance');
    }

    public function totalTrip()
    {
        return Ride::where('driver_id', $this->id)->count();
    }
}
