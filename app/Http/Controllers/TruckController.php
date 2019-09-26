<?php

namespace App\Http\Controllers;

use App\Truck;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::with('rides','fillups')
            ->orderBy('id', 'desc')
            ->get();

            return view('truck.trucks',compact('trucks'));
    }

    public function store(Request $request)
    {
        $truck = new Truck;
        $truck->license_plate = $request->license_plate;
        $truck->gas_card = $request->gas_card;
        $truck->mileage = $request->mileage;
        $truck->tank_capacity = $request->tank_capacity;
        $truck->last4vin = $request->last4vin;
        $truck->lable = $request->lable;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/truck'), $image);
            $truck->image = $image;
        }
        $truck->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$truck);

        return redirect('/trucks/')->with('status', $truck->license_plate." added!");

    }

    public function show($id)
    {
        $truck = Truck::with('rides','rides.rideable','rides.rideable.location','fillups','services')->find($id);
        $rides = $truck->rides()
        ->orderBy('created_at','desc')
        ->paginate(25);
        return view('truck.show',compact('truck','rides'));
    }

    public function update(Request $request)
    {
        $truck = Truck::find($request->id);
        $truck->license_plate = $request->license_plate;
        $truck->gas_card = $request->gas_card;
        $truck->mileage = $request->mileage;
        $truck->tank_capacity = $request->tank_capacity;
        $truck->last4vin = $request->last4vin;
        $truck->lable = $request->lable;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/truck'), $image);
            $truck->image = $image;
        }
        if($request->status=='on'){
            $truck->status = 1;
        } else {
            $truck->status = 0 ;
        }
        $truck->save();
        Transaction::log(Route::getCurrentRoute()->getName(),Truck::find($request->id),$truck);


        return redirect('/trucks/')->with('status', $truck->license_plate." Updated!");
    }

    public function destroy(Request $request,Truck $truck)
    {
        //Transaction::log(Route::getCurrentRoute()->getName(),$truck,false);
    }
}
