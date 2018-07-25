<?php

namespace App\Http\Controllers;

use App\Rideable;
use Auth;
use Illuminate\Http\Request;

class RideableController extends Controller
{
    public function home(Request $request)
    {
        $deliveries = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->whereHas('location',function($q){
            $q->where('type', 'Client');
        })
        ->where('status', '!=', 'Done')
        ->where('status', '!=', 'Canceled')
        ->orderBy('location_id', 'desc')
        ->get();
        $pickups = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->whereHas('location', function($q){
            $q->where('type', '!=', 'Client');
        })
        ->where('status', '!=', 'Done')
        ->where('status', '!=', 'Canceled')
        ->orderBy('location_id', 'desc')
        ->get();
        if($request!==null){
            // dd($request);
            $flashId = $request->id;
        }else $flashId = '1';
        return view('home',compact('deliveries','pickups','flashId'));

    }

    public function list(Request $request, $type)
    {
        $arr = array();
        if($type == "delivery"){
            $op1 = 'Client';
            $op2 = 'Delivery';
            $operator = '=';
        } else {
            $op1 = 'Warehouse';
            $op2 = 'Pickup';
            $operator = '!=';
        }
        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->where('type',$op2)
        ->whereHas('location', function($q) use ($operator) {
            $q->where('type', $operator, 'Client');
        })
        ->where('status','!=','Done')
        ->where('status','!=','Canceled')
        ->orderBy('location_id', 'desc')
        ->get();

        if($request!==null){
            // dd($request);
            $flashId = $request->id;
        }else $flashId = '1';
        return view('rideable.rideables',compact('rideables','op1','op2','flashId'));
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

            if(Auth::user()->id==$rideable->user_id){
                // dd($rideable->rides()->first());
                if($rideable->rides()->first()!=null){
                    $ride_id = $rideable->rides()->first()->id;
                    $rideable->rides()->detach($ride_id);
                    Ride::destroy($ride_id);
                }
                Rideable::destroy($rideable->id);
                return redirect('/')->with('status', 'Rideable Destroid!');
            }

        return redirect()->back()->with('status', 'Access Denied. You are not the one '.$rideable->user->name.' who created it!');
    }
}
