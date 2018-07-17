<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function fillups()
    {
        return $this->hasMany(Fillup::class);
    }

}
