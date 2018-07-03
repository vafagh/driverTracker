<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function address()
    {
        return $this->hasOne('App\Address');
    }
    // For 1.delivery from distributers(warehouses) to client and 2.Base warehouse to clients
    public function deliverable()
    {
        return $this->morghTo();
    }
}
