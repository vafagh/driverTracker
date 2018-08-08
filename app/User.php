<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    use Notifiable;

    protected $fillable = [ 'name', 'email', 'password' ];

    protected $hidden = [ 'password', 'remember_token' ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
