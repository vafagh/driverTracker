<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Driver;
use App\Rideable;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DriverController extends Controller
{

    public function index()
    {
        $drivers = Driver::with('rides','fillups','rides.truck','rides.rideable.location')
        ->orderByDesc('working')
        ->orderBy('truck_id')
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
        $driver = Driver::with('rides','fillups','rides.truck','rides.rideable','rides.rideable.location')->find($driver_id);
        (empty($request->input('sortby'))) ? $rideSort = 'created_at': $rideSort = $request->input('sortby');

        $finishedRides = $driver->rides()
            ->whereHas('rideable', function($q) {
                $q->where('status', 'OnTHeWay');
            })
            ->orderBy('created_at','desc')
            ->paginate(20);
        $ongoingRides = $driver->rides()
            ->whereHas('rideable', function($q) {
                $q->where('status', '!=','OnTHeWay');
            })
            ->orderBy('created_at','desc')
            ->get();

        $currentUnassign = Rideable::doesntHave('rides')
            ->where([
                ['status','!=','Done'],
                ['status','!=','Canceled'],
                ['status','!=','Return'],
                ['delivery_date','=',Carbon::today()->toDateString()],
                // ['shift','=',(date('H')<15) ? 'Morning' : 'Evening']
                // ['status','=','Created'],
                // ['status','=','DriverDetached'],
            ])
            ->orderBy('invoice_number', 'asc')->get();

        return view('driver.show',compact('driver','finishedRides','ongoingRides','rideSort','currentUnassign'));
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
            if($request->working=='on'){
                $driver->working = true;
            } else {
                $driver->working = false ;
                $driver->truck_id = NULL;
            }
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
