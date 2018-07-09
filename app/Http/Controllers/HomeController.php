<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rideable;
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
        // $deliveries = Ride::where('status','!=','Delivered')->get();
        $Rideables = Rideable::all();
        // $pickups = Rideable::where('type','Pickup')->get();
        // dd($Rideables->first()->location());
        return view('home',compact('Rideables'));
    }
}
