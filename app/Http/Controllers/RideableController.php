<?php

namespace App\Http\Controllers;

use Auth;
use App\Rideable;
use App\Ride;
use App\Location;
use App\Driver;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RideableController extends Controller
{
    public function home(Request $request)
    {
        // $deliveries = Rideable::with('user','rides','rides.driver','rides.truck','location')
        //     ->whereHas('location',function($q){
        //         $q->where('type', 'Client');
        //     })
        //     ->where('status', '!=', 'Done')
        //     ->where('status', '!=', 'Canceled')
        //     ->orderBy('location_id', 'asc')
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        // $pickups = Rideable::with('user','rides','rides.driver','rides.truck','location')
        //     ->whereHas('location', function($q){
        //         $q->where('type', '!=', 'Client');
        //     })
        //     ->where('status', '!=', 'Done')
        //     ->where('status', '!=', 'Canceled')
        //     ->orderBy('location_id', 'desc')
        //     ->get();
        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
            // ->whereHas('rides')
            ->where('status', '!=', 'Done')
            ->where('status', '!=', 'Canceled')
            ->orderBy('location_id', 'desc')
            ->paginate(50);
        // $drivers = Driver::with('rides','rides.truck','rides.rideable','rides.rideable.location','fillups')
        //     ->whereHas('rides.rideable', function($q){
        //         $q->where('status', '!=', 'Done')
        //           ->where('status', '!=', 'Canceled');
        //     })
        //     ->get();

        $warehouses = Location::where('type','!=','Client')->get();
        return view('home',compact('rideables','flashId','warehouses'));
    }

    public function show(Rideable $rideable)
    {
        return view('rideable.show',compact('rideable','clients'));
    }

    public function list(Request $request, $type)
    {
        if($type == "delivery") { $op1 = 'Client';    $op2 = 'Delivery'; $operator = '=';  $orderColumn = 'invoice_number'; }
        else                    { $op1 = 'Warehouse'; $op2 = 'Pickup';   $operator = '!='; $orderColumn = 'location_id';}

        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
            ->whereHas('location', function($q) use ($operator) {
                $q->where('type', $operator, 'Client');
            })
            ->where('status','!=','Done')
            ->where('status','!=','Canceled')
            ->orderBy($orderColumn, 'desc')
            ->paginate(50);
        ($request!==null) ? $flashId = $request->id : $flashId = '1';

        return view('rideable.rideables',compact('rideables','op1','op2','flashId'));
    }

    public function status(Request $request)
    {
        $rideable=Rideable::find($request->rideable);
        $rideable->status = $request->status;
        Transaction::log(Route::getCurrentRoute()->getName(),Rideable::find($request->rideable),$rideable);
        $rideable->save();

        return redirect()->back()->with('status', $rideable->status.' set');
    }

    public function store(Request $request)
    {
        $rideable = new Rideable;
        $rideable->user_id = Auth::id();
        (is_null($request->locationName)) ? $locationName = $request->locationPhone : $locationName = $request->locationName;
        if($request->type=='Delivery'){
            if(Location::where('longName', $locationName)->first()==null) {return redirect()->back()->with('error', 'Location "'.$locationName.'" not exist. Make sure you select it from list. ');}
            else{$rideable->location_id = Location::where('longName', $locationName)->first()->id;}
        }else{
            $rideable->location_id = $locationName;
        }
        $msg = Location::addGeo(Location::find($rideable->location_id));
        $rideable->invoice_number = $request->invoice_number;
        $rideable->type = Location::find($rideable->location_id)->type;
        $rideable->status = 'Created';
        $rideable->description = $request->description;
        $rideable->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);

        return redirect()->back()->with('status', '#'.$rideable->invoice_number." added! ".$msg);

    }

    public function update(Request $request)
    {
        $rideable = Rideable::find($request->id);
        // belowe line is commentet to preserve the original creator.
        $rideable->user_id = Auth::user()->id;
        $rideable->invoice_number = $request->invoice_number;
        $rideable->type = $request->type;
        $rideable->type = $request->type;
        $rideable->status = $request->status;
        $rideable->description = $request->description;
        $rideable->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);

        return redirect()->back()->with('status', '#'.$rideable->invoice_number." updated!");

    }

    public function destroy(Rideable $rideable,Request $request)
    {
            if(Auth::user()->id==$rideable->user_id){
                if($rideable->rides()->first()!=null){
                    $ride_id = $rideable->rides()->first()->id;
                    $rideable->rides()->detach($ride_id);
                    Ride::destroy($ride_id);
                }
                Rideable::destroy($rideable->id);
                Transaction::log(Route::getCurrentRoute()->getName(),$rideable,false);

                return redirect()->back()->with('status', 'Rideable Destroid!');
            }

        return redirect()->back()->with('status', 'Access Denied. You are not the one '.$rideable->user->name.' who created it!');
    }
}
