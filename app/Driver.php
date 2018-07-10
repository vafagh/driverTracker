<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function trucks()
    {
        return $this->belongsToMany(Truck::class);
    }
}
