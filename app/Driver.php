<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function rides()
    {
        return $this-hasMany(Truck::class)->withPivot('created_at', 'updated_at');
    }

    public function fillups()
    {
        return $this->hasMany(Fillup::class);
    }
}
