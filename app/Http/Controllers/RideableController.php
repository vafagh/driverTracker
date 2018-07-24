<?php

namespace App\Http\Controllers;

use App\Rideable;
use Auth;
use Illuminate\Http\Request;

class RideableController extends Controller
{
    public function home()
    {
        $deliveries = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->where('type','Delivery')
        ->where('status','!=','Done')
        ->where('status','!=','Canceled')
        ->orderBy('location_id', 'desc')
        ->get();
        $pickups = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->where('type','Pickup')
        ->where('status','!=','Done')
        ->where('status','!=','Canceled')
        ->orderBy('location_id', 'desc')
        ->get();

        return view('home',compact('deliveries','pickups','draftRideable'));

    }

    public function list($type)
    {
        if($type == "pickups")
        {$op1 = 'Warehouse'; $op2 = 'Pickup';} else {
            $op1 = 'Client'; $op2 = 'Delivery';
        }
        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->where('type',$op2)
        ->where('status','!=','Done')
        ->where('status','!=','Canceled')
        ->orderBy('location_id', 'desc')
        ->get();

        return view('rideable',compact('rideables','op1','op2'));
    }

    public function status(Request $request)
    {
        $rideable=Rideable::find($request->rideable);
        $rideable->status = $request->status;
        $rideable->save();

        return redirect('/#rideable'.$rideable->id)->with('status', $rideable->status.' set');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rideable = new Rideable;
        $rideable->user_id = Auth::id();
        $rideable->location_id = $request->location;
        $rideable->invoice_number = $request->invoice_number;
        $rideable->type = $request->type;
        $rideable->status = 'Created';
        $rideable->description = $request->description;
        $rideable->save();
        return redirect()->back()->with('status', '#'.$rideable->invoice_number." added!");

    }

    public function show(Rideable $rideable)
    {
        //
    }

    public function edit(Rideable $rideable)
    {
        //
    }

    public function update(Request $request, Rideable $rideable)
    {
        //
    }

    public function destroy(Rideable $rideable)
    {
        //
    }
}
