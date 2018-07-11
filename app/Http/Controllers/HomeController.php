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
        $draftRideable = Rideable::doesntHave('trucks')->get();
        $deliveries = Rideable::with('trucks')->where('type','Delivery')->get();
        $pickups = Rideable::where('type','Pickup')->get();
        // dd(Rideable::find(2)->locations->first()->name);
        return view('home',compact('deliveries','pickups','draftRideable'));
    }
}
