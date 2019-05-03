<?php

namespace App\Http\Controllers;

use App\Ride;
use App\Truck;
use App\Fillup;
use App\Service;
use App\Driver;
use App\Location;
use App\Rideable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(Request $request)
    {
        $warehouses = Location::with('rideables','rideables.rides')
                              ->whereHas('rideables', function($q) {
                                  $q->where('status', 'Created');
                              })
                              ->where('type','!=','Client')
                              ->get();
        return view('home',compact('rideables','warehouses'));
    }

    public function find(Request $request)
    {
        $term = $request->input('q');
            if(is_null($term)) return redirect()->back()->with('warning', 'You didn\'t type enythings to search!');
        $invoices = Rideable::where('invoice_number','like','%'.$term.'%')->orWhere('description','like','%'.$term.'%')->orWhere('created_at','like','%'.$term.'%')->orderBy('invoice_number','asc')->paginate(30);;
        $rides = Ride::where('created_at','like','%'.$term.'%')->orderBy('id','asc')->paginate(30);;
        $drivers = Driver::where('fname','like','%'.$term.'%')->orWhere('lname','like','%'.$term.'%')->orWhere('phone','like','%'.$term.'%')->orderBy('fname','asc')->paginate(30);;
        $trucks = Truck::where('lable','like','%'.$term.'%')->orWhere('last4vin','like','%'.$term.'%')->orWhere('license_plate','like','%'.$term.'%')->orderBy('lable','asc')->paginate(30);;
        $locations = Location::where('name','like','%'.$term.'%')->orWhere('longName','like','%'.$term.'%')->orWhere('phone','like','%'.$term.'%')->orWhere('person','like','%'.$term.'%')->orWhere('line1','like','%'.$term.'%')->orWhere('line2','like','%'.$term.'%')->orWhere('city','like','%'.$term.'%')->orWhere('state','like','%'.$term.'%')->orWhere('zip','like','%'.$term.'%')->orderBy('name','asc')->paginate(30);;
        $fillups = Fillup::where('gas_card','like','%'.$term.'%')->orWhere('total','like','%'.$term.'%')->orWhere('mileage','like','%'.$term.'%')->orderBy('created_at','desc')->paginate(30);;
        $fillups = Service::where('description','like','%'.$term.'%')->orWhere('product','like','%'.$term.'%')->orWhere('shop','like','%'.$term.'%')->orWhere('total','like','%'.$term.'%')->orWhere('mileage','like','%'.$term.'%')->orderBy('created_at','desc')->paginate(30);;
        return view('results.result',compact('invoices','drivers','trucks','fillups','locations','rides'));
    }
}
