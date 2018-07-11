<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fillup extends Model
{
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
