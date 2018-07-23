<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Ride;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{

    public function index()
    {
        $drivers = Driver::all();
        return view('driver.drivers',compact('drivers'));
    }

    public function totalDistance()
    {
        return Ride::where('driver_id', $this->id)->sum('distance');
    }

    public function totalTrip()
    {
        return Ride::where('driver_id', $this->id)->count();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $driver = new Driver;

        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/avatars'), $image);
            $driver->image = $image;
        }
        $driver->fname = $request->fname;
        $driver->lname = $request->lname;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->save();
        return redirect('/drivers/')->with('status', $driver->fname." added!");
    }

    public function show($driver_id)
    {
        // $rides = Ride::with('rideable','rideable.location','driver','truck')
        // ->where('driver_id',$driver_id)
        // ->orderBy('id', 'desc')
        // ->get();
        $driver = Driver::with('rides','fillups')->find($driver_id);
// dd($driver->fillups);
        return view('driver.show',compact('driver'));
    }

    public function edit(Driver $driver)
    {
        //
    }

    public function update(Request $request)
    {
        $driver = Driver::find($request->id);
        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/avatars'), $image);
            $driver->image = $image;
        }
        $driver->fname = $request->fname;
        $driver->lname = $request->lname;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        $driver->save();
        return redirect('/drivers/')->with('status', $driver->fname." Updated!");
    }

    public function destroy(Driver $driver)
    {
        //
    }
}
