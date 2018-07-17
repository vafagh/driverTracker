<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Rideable;
use Auth;
use Illuminate\Http\Request;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::with('user','rideable','rideables.driver','rideables.truck','location')
        ->orderBy('id', 'desc')
        ->get();

        return view('ride',compact('rides'));
    }

    public function create(Rideable $rideable)
    {
        return view('ride',compact('rideable'));
    }

    public function attach(Request $request)
    {
        $ride = new Ride;
        $ride->rideable_id = $request->id;
        $ride->truck_id = $request->truck;
        $ride->driver_id = $request->driver;
        $ride->distance = $request->distance;
        $ride->save();

        $rideable=Rideable::find($request->id);
        $rideable->status = 'On The Way';
        $rideable->save();
        $rideable->rides()->attach($ride->id);

        return redirect('/')->with('status', 'Driver Assigned');

    }

    public function detach($ride_id,$rideable_id)
    {
        $rideable=Rideable::find($rideable_id);
        $rideable->status = 'Canceled';
        $rideable->save();
        if($ride_id > 0){
            $rideable->rides()->detach($ride_id);
            Ride::destroy($ride_id);
        }else {
            return redirect('/')->with('error', 'Ride not found!');
        }

        return redirect('/')->with('status', 'Driver dismissed from this task');
    }

    public function show(Ride $ride)
    {
        //
    }

    public function edit(Ride $ride)
    {
        //
    }

    public function update(Request $request, Ride $ride)
    {
        //
    }

    public function destroy(Ride $ride)
    {
        //
    }
}
