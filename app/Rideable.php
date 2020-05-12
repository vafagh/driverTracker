<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rideable extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function rides()
    {
        return $this->belongsToMany(Ride::class)->withPivot('created_at','updated_at');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
