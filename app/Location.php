<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public function ridables()
    {
        return $this->belongsToMany(Ridable::class);
    }

}
