<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function address()
    {
        return $this->hasOne('App\Address');
    }

    public function pickup()
    {
        return $this->belongsToMany('App\Pickup');
    }

    // Return parts to supplier
    public function delivery()
    {
        return $this->belongsToMany('App\Delivery');
    }
}
