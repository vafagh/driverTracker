<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;


class Location extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function rideables()
    {
        return $this->hasMany(Rideable::class);
    }

    public function getGeo(Location $location)
    {
        $key = 'AIzaSyC9WbAiOnaNG5mC7o5JTINYoGM06ryveKE';
        $address = str_replace(' ', '+', $this->line1.$this->city.$this->state);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?';
        $request = $url.'address='.$address.'&key='.$key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec($ch);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;

    }

    static public function addGeo(Location $location)
    {
        $gmaprespond = $location->getGeo($location);
        if($gmaprespond->status == 'OK'){
            $location->lat = $gmaprespond->results[0]->geometry->location->lat;
            $location->lng = $gmaprespond->results[0]->geometry->location->lng;
        }
        Transaction::log(Route::getCurrentRoute()->getName(),Location::find($location->id),$location);
        $location->save();
    }

}
