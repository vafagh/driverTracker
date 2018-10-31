<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
