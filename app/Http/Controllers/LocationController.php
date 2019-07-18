<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Driver;
use App\Location;
use App\Rideable;
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
        try{
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
        }catch(\Exception $e){
            if($e->errorInfo[1] == 1062) return $this->show(Location::where('phone',$location->phone)->first())->with('error', $e->errorInfo[2]);
            return back()->with('error', $e->errorInfo[2]);
        }
        Transaction::log(Route::getCurrentRoute()->getName(),'',$location);

        return redirect('locations')->with('status', $location->name.' Added');
    }

    public function show(Location $location,$route=1)
    {
        if($location->type == "Warehouse"){
            $op1 = 'Warehouse'; $op2 = 'Pickup';
        } else {
            $op1 = 'Client'; $op2 = 'Delivery';
        }
        $rideables = $location->rideables()
            ->orderBy('created_at','desc')
            ->paginate(10);
        return view('location.show',compact('location','rideables','op1','op2','route'));
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
        if($location->lat == null || $location->lng == null || $request->updateGeo == 'on' ){
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

    public function defaultDriver(Location $location, Driver $driver)
    {
        $oldLocation = $location;
        $msg = 'Default driver and ';
        $location->driver_id = $driver->id;
        if($location->lat == null || $location->lng == null){
            $gmaprespond = $location->getGeo($location);
            if($gmaprespond->status == 'OK'){
                $location->lat = $gmaprespond->results[0]->geometry->location->lat;
                $location->lng = $gmaprespond->results[0]->geometry->location->lng;
                $msg = $msg.'Geo data and other information for ';
            }else{$msg = $msg.'Geo_'.$gmaprespond->status.'('.$gmaprespond->error_message.') but other info for ';}
        }
        Transaction::log(Route::getCurrentRoute()->getName(),$oldLocation,$location);
        $location->save();

        return redirect()->back()->with('status',$msg.$location->name.' updated');
    }

    public function clearDefault(Location $location)
    {
        if(empty($location->id)){
            Location::whereNotNull('driver_id')->update(['driver_id' => null]); // clear all driver from default value on location
            $rideables = Rideable::whereIn('status',['DriverDetached','OnTheWay'])->get(); //collect all undone except 'Reschedule'd and 'Created'
            foreach ($rideables as $rideable) { // detach and destroy current undone rides for rideable
                if($rideable->rides()->count() > 0){
                    $rideable->rides()->detach();
                    foreach (Ride::where('rideable_id',$rideable->id)->get() as $child) {
                        Ride::destroy($child->id);
                    }
                }
                $oldRideable = $rideable;
                $rideable->status = 'Created';
                $rideable->save();
                Transaction::log(Route::getCurrentRoute()->getName(),$oldRideable,$rideable);
            }

            $msg = 'locations.';
        }else{
            $oldLocation = $location;
            $msg = $location->longName;
            $location->update(['driver_id' => null]);
            Transaction::log(Route::getCurrentRoute()->getName(),$oldLocation,$location);
        }

        return redirect()->back()->with('status', 'Driver unassigned from '.$msg);
    }

    public function destroy(Location $location, Request $request)
    {
        Location::destroy($location->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$location,false);

        return redirect('/locations')->with($location->name.' Deleted');
    }
}
