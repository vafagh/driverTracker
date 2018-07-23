<?php

namespace App\Http\Controllers;

use App\Fillup;
use Illuminate\Http\Request;

class FillupController extends Controller
{
    public function index()
    {
        $fillups = Fillup::with('driver','truck')
        ->orderBy('id', 'desc')
        ->get();

        return view('fillups',['fillups'=>$fillups]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $fillup = new Fillup;
        $fillup->truck_id = $request->truck_id;
        $fillup->driver_id = $request->driver_id;
        $fillup->gas_card = $request->gas_card;
        $fillup->gallons = $request->gallons;
        $fillup->product = $request->product;
        $fillup->price_per_gallon = $request->price_per_gallon;
        $fillup->total = $request->total;
        $fillup->mileage = $request->mileage;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/fillup'), $image);
            $fillup->image = $image;
        }
        $fillup->save();

        return redirect()->back();
    }

    public function show(Fillup $fillup)
    {
        //
    }

    public function edit(Fillup $fillup)
    {
        //
    }


    public function update(Request $request, Fillup $fillup)
    {
        $fillup->truck_id = $request->truck_id;
        $fillup->driver_id = $request->driver_id;
        $fillup->gas_card = $request->gas_card;
        $fillup->gallons = $request->gallons;
        $fillup->product = $request->product;
        $fillup->price_per_gallon = $request->price_per_gallon;
        $fillup->total = $request->total;
        $fillup->mileage = $request->mileage;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/fillup'), $image);
            $fillup->image = $image;
        }
        $fillup->save();

        return redirect()->back();
    }

    public function destroy(Fillup $fillup)
    {
        Fillup::destroy($fillup->id);
        return redirect()->back()->with('status', 'Ride Destroid!');
    }
}
