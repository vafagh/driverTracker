<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public function ride()
    {
        return $this->morghMany('App\Ride', 'ridable');
    }

    public function client()
    {
        return $this->morghMany('App\Client', 'deliverable');
    }

    public function warehouse()
    {
        return $this->hasOne('App\Warehouse');
    }
}
