<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
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
    public function driver()
    {
        return Driver::where('truck_id',$this->id)->first();
    }

}
