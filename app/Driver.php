<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function rides()
    {
        return $this-hasMany(Truck::class)->withPivot('created_at', 'updated_at');
    }

    public function fillups()
    {
        return $this->hasMany(Fillup::class);
    }
}
