<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;


class Location extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    // use Notifiable;

	protected $fillable = [
        'type','name','longName','person','image','phone','distance','line1','line2','city','state','zip'
	];

    public function rideables()
    {
        return $this->hasMany(Rideable::class);
    }

    public function getGeo(Location $location)
    {
        $key = env('GOOGLE_MAP_API');
        $address = str_replace(' ', '+', $this->line1.'+'.$this->city.'+'.$this->state);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?';
        $request = $url.'address='.$address.'&key='.$key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return $response;

    }

    static public function addGeo(Location $location)
    {
        if($location->lat==Null || $location->lat=='' || $location->lng==Null || $location->lng=='' ){
            $gmaprespond = $location->getGeo($location);
            if($gmaprespond->status == 'OK'){
                $location->lat = $gmaprespond->results[0]->geometry->location->lat;
                $location->lng = $gmaprespond->results[0]->geometry->location->lng;
                Transaction::log(Route::getCurrentRoute()->getName(),Location::find($location->id),$location);
                $location->save();
            }else{ return 'Google Map API:'.$gmaprespond->status;}
        }
    }
    // static public function favorites(Location $location)
    // {
    //     //select invoice_number , count(*) as ordered from rideables where locatio4 group by invoice_number order by ordered DESC limit 10 ;
    // }
    public static function stylize($location,$store=null){
        return $store == 'store' ? env('STORE_LAT').','.env('STORE_LNG') : preg_replace('/\s+/', '+', $location->line1.'+'.$location->city.'+'.$location->state.'+'.$location->zip);
    }
}
