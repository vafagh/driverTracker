<?php

namespace App\Http\Controllers;

use Auth;
use App\Ride;
use App\Driver;
use App\Helper;
use App\Location;
use App\Rideable;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

class RideController extends Controller
{
    public function index()
    {
        $rides = Ride::with('rideable','rideable.location','driver','truck')
                ->orderBy('id', 'desc')
                ->paginate(10);

        return view('ride.rides',compact('rides'));
    }

    public function show($ride_id)
    {
        $ride = Ride::with('rideable','rideable.location','driver','truck')->find($ride_id);
        if ($ride==null) {
            return redirect()->back()->with('error', 'Ride with Id of '.$ride_id.' no longer exict!');
        }else return view('ride.show',compact('ride'));
    }

    public function create(Rideable $rideable)
    {
        return view('ride.create',compact('rideable'));
    }

    public function attach(Request $request)
    {
        // $ride = new Ride;
        // $ride->rideable_id = $request->id;
        // if(is_null($request->driver)){return redirect()->back()->with('error', 'Please choice the driver!');}
        // $ride->truck_id    = Driver::find($request->driver)->truck_id;
        // $ride->driver_id   = $request->driver;
        // $ride->shift       = (!is_null($request->shift))?$request->shift:((date('H') <= 14) ? 'Morning' : 'Eevening');
        // $ride->delivery_date = $request->delivery_date;
        // $ride->distance    = $request->distance;
        // $ride->save();
        //
        // $rideable=Rideable::find($request->id);
        // $msg = 'Driver Assigned';
        // // if($request->setShift == true){
        //     $rideable->shift = $request->shift;
        //     $rideable->delivery_date = $request->delivery_date;
        //     $msg = $msg.' and delivery set.';
        // // }
        // $rideable->status = 'OnTheWay';
        // $rideable->save();
        // $rideable->rides()->attach($ride->id);
        // Transaction::log(Route::getCurrentRoute()->getName(), $rideable, $ride);

        // return redirect()->back()->with('status', $msg);
        return redirect()->back()->with('warning', 'Unsuccessful!. Please use map to assign driver');

    }

    public function fastAttach(Rideable $rideable, Driver $driver)
    {
        // $ride = new Ride;
        // $ride->rideable_id = $rideable->id;
        // $ride->driver_id   = $driver->id;
        // $ride->truck_id    = $driver->truck_id;
        // $ride->distance    = $rideable->location->distance;
        // if(!empty($rideable->shift) )
        // {
        //     $ride->shift = $rideable->shift;
        // }else{
        //     $shifSetting = Helper::shift('Morning',1);
        //     if((date('H') > ($shifSetting['starts'] + $shifSetting['tolerance'])) && date('H') < $shifSetting['ends'] + $shifSetting['tolerance'])
        //     {
        //         $ride->shift='Evening';
        //     }else {
        //          $ride->shift='Morning';
        //     }
        // }
        // $ride->delivery_date = $rideable->delivery_date;
        // $ride->save();
        // $rideable->status = 'OnTheWay';
        // $rideable->shift = $ride->shift;
        // $rideable->save();
        // $rideable->rides()->attach($ride->id);
        // Transaction::log(Route::getCurrentRoute()->getName(),$rideable,$ride);
        //
        // return redirect()->back()->with('status', $driver->fname.' Assigned to '.$rideable->invoice_number.' For '.$rideable->location->name.' on '.$ride->shift.' shift');
        return redirect()->back()->with('error', $rideable->invoice_number.' didn\'t assigned to '. $driver->fname.' Please use map to assign drivers');

    }

    public function mapAttach(Location $location, Driver $driver,$date,$shift)
    {
        $invoice_numbers       = '';
        // get all ongoing rideables for each location

        if($location->type == 'Warehouse') return redirect()->action('LocationController@defaultDriver', [$location, $driver,0,0]);
        $elegibleRidables = $location->rideables->whereIn('status', Helper::filter('ongoing'))->where('delivery_date','=',$date)->where('shift','=',$shift);
        foreach ($elegibleRidables as $rideable) {
            // detach and destroy current undone rides for rideable
            if($rideable->rides()->count() > 0 && $rideable->status!='Reschedule' && $rideable->status!='Return'){
                $rideable->rides()->detach();
                foreach (Ride::where('rideable_id',$rideable->id)->get() as $child) {
                    Ride::destroy($child->id);
                }
            }
            //setting up new ride
            $ride              = new Ride;
            $ride->rideable_id = $rideable->id;
            $ride->driver_id   = $driver->id;
            $ride->truck_id    = $driver->truck_id;
            $ride->distance    = $rideable->location->distance;
            // setting the date and time
            $ride->delivery_date = (empty($rideable->delivery_date)) ? Helper::when($rideable)['date'] : $rideable->delivery_date;
            $ride->shift = (empty($rideable->shift)) ? Helper::when($rideable)['shift'] : $rideable->shift;
            $ride->delivery_date = $rideable->delivery_date;
            $ride->save();
            $invoice_numbers .= $rideable->invoice_number.', ';
            $rideable->status = 'OnTheWay';
            $rideable->shift = $ride->shift;
            $rideable->save();
            $rideable->rides()->attach($ride->id);
            $location->driver_id = $driver->id;
            $location->save();
        }
        Transaction::log(Route::getCurrentRoute()->getName(),$rideable,$driver);

        return redirect()->back()->with('status', $driver->fname.' Assigned to '.$invoice_numbers.' For '.$location->name.' on '.$ride->shift.' shift');

    }

    public function receive(Rideable $rideable, Driver $driver, $status)
    {
        $ride = new Ride;
        $today = new Carbon();
        $ride->rideable_id = $rideable->id;
        $ride->driver_id   = $driver->id;
        $ride->truck_id    = $driver->truck_id;
        $ride->distance    = $rideable->location->distance;
        $ride->shift       = date('H:i');
        $ride->delivery_date = $today->format('Y-m-d');
        $ride->save();

        $rideable->status = $status;
        $rideable->shift = $ride->shift;
        $rideable->delivery_date = $ride->delivery_date;
        $rideable->save();
        $rideable->rides()->attach($ride->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$rideable,$ride);

        return redirect()->back()->with('status', $driver->fname.' Assigned to '.$rideable->invoice_number.' For '.$rideable->location->name.' on '.$ride->shift.' shift');

    }

    public function detach($ride_id,$rideable_id, Request $request)
    {
        $rideable = Rideable::find($rideable_id);
        $rideable->status = 'DriverDetached';

        if($ride_id > 0){
            $rideable->rides()->detach($ride_id);
            Ride::destroy($ride_id);
        }else {
            return redirect('/')->with('error', 'Ride not found!');
        }

        $rideable->save();

        if ($rideable->rides()->count() < 2) {
            $location = Location::find($rideable->location->id);
            $location->driver_id = null;
            $location->save();
        }
        Transaction::log(Route::getCurrentRoute()->getName(),Rideable::find($rideable_id),$rideable);

        return redirect()->back()->with('status', 'Driver dismissed from this task');
    }

    public function edit(Ride $ride)
    {
        return view('edit');
    }

    public function update(Request $request)
    {
        $ride = Ride::find($request->id);
        $ride->driver_id = $request->driver;
        $ride->truck_id = $request->truck;
        $ride->shift = $request->shift;
        $ride->delivery_date = $request->delivery_date;
        $msg = 'Ride Updated!';
        if(empty($request->input('setShift')) == true){
            $ride->rideable->shift = $request->shift;
            $ride->rideable->delivery_date = $request->delivery_date;
            $ride->rideable->save();
            $msg = $msg.' and new delivery set.';
        }
        $ride->save();
        Transaction::log(Route::getCurrentRoute()->getName(),Ride::find($request->id),$ride);

        return redirect('/rides')->with('status', $msg);
    }

    public function destroy(Ride $ride)
    {
        Ride::destroy($ride->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$ride,$ride);

        return redirect()->back()->with('status', 'Ride Destroid!');
    }
}
