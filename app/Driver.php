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

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function totalDistance()
    {
        // return round(Ride::where('driver_id', $this->id)->sum('distance'),0);
    }

    public function totalTrip()
    {
        return Ride::where('driver_id', $this->id)->count();
    }
}
