<?php

namespace App\Http\Controllers;

use App\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::with('rides','fillups')
            ->orderBy('id', 'desc')
            ->get();

            return view('truck.trucks',compact('trucks'));
    }

    public function create()
    {
        //
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
        return redirect('/trucks/')->with('status', $truck->license_plate." added!");

    }

    public function show($id)
    {
        $truck = Truck::with('rides','rides.rideable','rides.rideable.location','fillups')->find($id);
        // dd($truck);
        return view('truck.show',compact('truck'));
    }

    public function edit(Truck $truck)
    {
        //
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
        $truck->save();

        return redirect('/trucks/')->with('status', $truck->license_plate." Updated!");
    }

    public function destroy(Truck $truck)
    {
        //
    }
}
