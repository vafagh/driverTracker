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
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('driver.drivers',compact('drivers'));
    }

    public function store(Request $request)
    {
        $driver = new Driver;
        $driver->fname = $request->fname;
        $driver->lname = $request->lname;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/driver'), $image);
            $driver->image = $image;
        }
        $driver->save();

        Transaction::log(Route::getCurrentRoute()->getName(),'',$driver);

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
        $driver->fname = $request->fname;
        $driver->lname = $request->lname;
        $driver->phone = $request->phone;
        $driver->email = $request->email;
        ($request->truck==='NULL') ? $driver->truck_id =NULL : $driver->truck_id = $request->truck;
        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/driver'), $image);
            $driver->image = $image;
        }

        Transaction::log(Route::getCurrentRoute()->getName(),Driver::find($request->id),$driver);

        $driver->save();

        return redirect('/drivers/')->with('status', $driver->fname." Updated!");
    }

    public function unassign(Driver $driver)
    {
        // $driver = Driver::find($request->id);
        $driver->truck_id = NULL;
        $driver->save();
        Transaction::log(Route::getCurrentRoute()->getName(),Driver::find($driver->id),$driver);

        return redirect('/drivers/')->with('status', $driver->fname." Updated!");
    }

    public function destroy(Request $request,Driver $driver)
    {
        Driver::destroy($driver->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$driver,false);

        return redirect('drivers')->with('status', $driver->fname." Deleted!");
    }
}
