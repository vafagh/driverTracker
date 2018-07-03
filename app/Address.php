<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function Client()
    {
        return $this->belongsTo('App\Client');
    }
    public function Warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }
}
