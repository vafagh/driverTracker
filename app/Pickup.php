<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    public function client()
    {
        return $this->morghMany('App\Client', 'deliverable');
    }

    public function warehouse()
    {
        return $this->hasOne('App\Warehouse');
    }

    public function ride()
    {
        return $this->morghMany('App\Ride', 'ridable');
    }
}
