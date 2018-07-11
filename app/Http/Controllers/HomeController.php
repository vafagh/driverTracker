<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rideable;
use App\Ride;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Rideable::with('user','rides','rides.driver','rides.truck','location')->where('type','Delivery')->get();
        $pickups = Rideable::with('user','rides','rides.driver','rides.truck','location')->where('type','Pickup')->get();
        // dd(Rideable::with('rides','rides.driver','rides.truck','location','rides.truck.fillups','rides.driver.fillups')->get());
        // dd(Ride::with('driver','truck')->get());
        return view('home',compact('deliveries','pickups','draftRideable'));
    }
}
