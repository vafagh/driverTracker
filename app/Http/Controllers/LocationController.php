<?php

namespace App\Http\Controllers;

use App\Location;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name','asc')->paginate(10);
        return view('location.locations',compact('locations'));
    }

    public function store(Request $request)
    {
        $location = new Location;
        $location->type = $request->type;
        $location->name = $request->name;
        $location->longName = $request->longName;
        $location->person = $request->person;
        $location->phone = $request->phone;
        $location->distance = $request->distance;
        $location->line1 = $request->line1;
        $location->line2 = $request->line2;
        $location->city = $request->city;
        $location->state = $request->state;
        $location->zip = $request->zip;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $structure = '../public/img/location/';
            if (!file_exists($structure)) {
                mkdir($structure, 0777, true);
            }
            $request->file('image')->move(public_path('img/location'), $image);
            $location->image = $image;
        }
        $gmaprespond = $location->getGeo($location);
        if($gmaprespond->status == 'OK'){
            $location->lat = $gmaprespond->results[0]->geometry->location->lat;
            $location->lng = $gmaprespond->results[0]->geometry->location->lng;
        }
        $location->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$location);

        return redirect('locations')->with($location->name.' Added');
    }

    public function show(Location $location)
    {
        if($location->type == "Warehouse"){
            $op1 = 'Warehouse'; $op2 = 'Pickup';
        } else {
            $op1 = 'Client'; $op2 = 'Delivery';
        }
        $rideables = $location->rideables()
            ->orderBy('created_at','desc')
            ->paginate(10);
        return view('location.show',['location'=>$location,'rideables'=>$rideables,'op1'=>$op1,'op2'=>$op2]);
    }

    public function update(Request $request)
    {
        $location = Location::find($request->id);
        $msg = '';
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $structure = '../public/img/location/';
            if (!file_exists($structure)) {
                mkdir($structure, 0777, true);
            }
            $request->file('image')->move(public_path('img/location'), $image);
            $location->image = $image;
        }elseif ($request->clearimg == 'on') {
            $location->image = null;
        }
        $location->type = $request->type;
        $location->name = $request->name;
        $location->longName = $request->longName;
        $location->person = $request->person;
        $location->phone = $request->phone;
        $location->distance = $request->distance;
        $location->line1 = $request->line1;
        $location->line2 = $request->line2;
        $location->city = $request->city;
        $location->state = $request->state;
        $location->zip = $request->zip;
        if($location->lat == null || $location->lng == null){
            $gmaprespond = $location->getGeo($location);
            if($gmaprespond->status == 'OK'){
                $location->lat = $gmaprespond->results[0]->geometry->location->lat;
                $location->lng = $gmaprespond->results[0]->geometry->location->lng;
                $msg = $msg.'Geo data and other information for ';
            }else{$msg = $msg.'Geo_'.$gmaprespond->status.'('.$gmaprespond->error_message.') but other info for ';}
        }
        Transaction::log(Route::getCurrentRoute()->getName(),Location::find($request->id),$location);
        $location->save();

        return redirect()->back()->with('status',$msg.$location->name.' updated');
    }

    public function destroy(Location $location, Request $request)
    {
        Location::destroy($location->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$location,false);

        return redirect('/locations')->with($location->name.' Deleted');
    }
}
