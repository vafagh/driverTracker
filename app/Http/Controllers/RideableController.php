<?php

namespace App\Http\Controllers;

use Auth;
use App\Rideable;
use App\Location;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
            ->orderBy('location_id', 'asc')
            ->orderBy('created_at', 'desc')
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
            $flashId = $request->id;
        }else $flashId = '1';
        $warehouses = Location::where('type','!=','Client')->get();
        return view('home',compact('deliveries','pickups','flashId','warehouses'));
    }

    public function show(Rideable $rideable)
    {
        return view('rideable.show',compact('rideable','clients'));
    }

    public function list(Request $request, $type)
    {
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
        Transaction::log(Route::getCurrentRoute()->getName(),Rideable::find($request->rideable),$rideable);
        $rideable->save();

        return redirect('/#rideable'.$rideable->id)->with('status', $rideable->status.' set');
    }

    public function store(Request $request)
    {
        $rideable = new Rideable;
        $rideable->user_id = Auth::id();
        ($request->type=='Delivery') ?  $rideable->location_id = Location::where('longName', $request->location)->first()->id : $rideable->location_id = $request->location;
        $rideable->invoice_number = $request->invoice_number;
        $rideable->type = $request->type;
        $rideable->status = 'Created';
        $rideable->description = $request->description;
        $rideable->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);

        return redirect()->back()->with('status', '#'.$rideable->invoice_number." added!");

    }

    public function update(Request $request)
    {
        $rideable = Rideable::find($request->id);
        // belowe line is commentet to preserve the original creator.
        // $rideable->user_id = Auth::id();
        ($request->type=='Delivery') ?
            $rideable->location_id = Location::where('longName', $request->location)->first()->id :
            $rideable->location_id = $request->location;
        $rideable->invoice_number = $request->invoice_number;
        $rideable->type = $request->type;
        $rideable->type = $request->type;
        $rideable->status = $request->status;
        $rideable->description = $request->description;
        $rideable->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);

        return redirect()->back()->with('status', '#'.$rideable->invoice_number." added!");

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

                return redirect('/')->with('status', 'Rideable Destroid!');
            }

        return redirect()->back()->with('status', 'Access Denied. You are not the one '.$rideable->user->name.' who created it!');
    }
}
