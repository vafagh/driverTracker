<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ridable;
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
        $ridables = Ridable::where('type','Delivery')->get();
        // $pickups = Ridable::where('type','Pickup')->get();
        // dd($ridables->first()->location());
        return view('home',compact('ridables'));
    }
}
