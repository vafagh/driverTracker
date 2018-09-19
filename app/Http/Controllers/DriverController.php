<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Driver;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DriverController extends Controller
{

    public function index()
    {
        $drivers = Driver::with('rides','fillups','rides.truck','rides.rideable.location')
        ->orderBy('fname')
        ->get();

        return view('driver.drivers',compact('drivers'));
    }

    public function store(Request $request)
    {
        $driver = new Driver;
        $driver->fname = $request->fname;
        $driver->lname = $request->lname;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        ($request->truck == 'clear') ? $driver->truck_id = null : $driver->truck_id = $request->truck;
        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/driver'), $image);
            $driver->image = $image;
        }
        $driver->save();

        Transaction::log(Route::getCurrentRoute()->getName(),'',$driver);

        return redirect('/drivers/')->with('status', $driver->fname." added!");
    }

    public function show($driver_id, Request $request)
    {
        $driver = Driver::with('rides','fillups','rides.truck','rides.rideable.location')->find($driver_id);
        (empty($request->input('sortby'))) ? $rideSort = 'created_at': $rideSort = $request->input('sortby');
        $rides = $driver->rides()
        ->orderBy('created_at','desc')
        ->paginate(20);
        return view('driver.show',compact('driver','rides','rideSort'));
    }


    public function update(Request $request)
    {
        try{
            $driver = Driver::find($request->id);
            $driver->fname = $request->fname;
            $driver->lname = $request->lname;
            $driver->phone = $request->phone;
            $driver->email = $request->email;
            ($request->truck == 'clear') ?  $driver->truck_id=null : $driver->truck_id = $request->truck;
            if($request->file('avatar')!=NULL){
                $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
                $request->file('avatar')->move(public_path('img/driver'), $image);
                $driver->image = $image;
            }

            Transaction::log(Route::getCurrentRoute()->getName(),Driver::find($request->id),$driver);

            $driver->save();

            return redirect('/drivers/')->with('status', $driver->fname." Updated!");
        }
        catch(\Exception $e){
            return back()->with('error', $e);
        }
    }

    public function unassign(Driver $driver)
    {
        $old_record = Driver::find($driver->id);
        $driver->truck_id = NULL;
        $driver->save();
        Transaction::log(Route::getCurrentRoute()->getName(),$old_record,$driver);

        return redirect('/drivers/')->with('status', $driver->fname." Updated!");
    }

    public function destroy(Request $request,Driver $driver)
    {
        Driver::destroy($driver->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$driver,false);

        return redirect('drivers')->with('status', $driver->fname." Deleted!");
    }
}
