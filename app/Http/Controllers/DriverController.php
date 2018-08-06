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
        $drivers = Driver::with('rides','fillups','rides.truck','rides.rideable.location')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('driver.drivers',compact('drivers'));
    }


    public function store(Request $request)
    {
        $driver = new Driver;

        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/driver'), $image);
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
        $driver = Driver::with('rides','fillups','rides.truck','rides.rideable.location')->find($driver_id);
        $rides = $driver->rides;
        // ->paginate(10);
        return view('driver.show',compact('driver','rides'));
    }


    public function update(Request $request)
    {
        $driver = Driver::find($request->id);
        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/driver'), $image);
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
        Driver::destroy($driver->id);
        return redirect('drivers')->with('status', $driver->fname." Deleted!");
    }
}
