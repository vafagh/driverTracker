<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    public function rideable()
    {
        return $this->belongsTo(Rideable::class);
    }
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
