<?php

namespace App\Http\Controllers;

use Auth;
use App\Ride;
use App\Truck;
use App\Helper;
use App\Fillup;
use App\Service;
use App\Driver;
use App\Location;
use App\Rideable;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(Request $request)
    {
        if(empty($request->shift)){
            $shift = (date('H') < 13) ? 'Morning' : 'Evening';
        }else{
            $shift = $request->shift;
        }
        $history = $request->history;
        if(empty($request->history)){
            $today = new Carbon();
            $history = $today->format('Y-m-d');
            $warehouses = Location::where('type','!=','Client')
                                ->whereHas('rideables', function($q) use($history){
                                    $q->where('delivery_date', $history); // all todays pickup
                                    $q->orWhere('status', Helper::filter('ongoing')); // all ongoing pickups
                                })
                                ->with('rideables')
                                ->get();
        }else{
            $warehouses = Location::where('type','!=','Client')
                                ->whereHas('rideables', function($q) use($history){
                                    $q->where('delivery_date','=',$history);
                                })
                                ->with('rideables')
                                ->get();
        }
        $when = [$history,$shift];
        $hisexp = explode('-', $history);
        $dt = Carbon::create($hisexp[0],$hisexp[1],$hisexp[2],0 ,0,0,'America/Chicago');

        $assigned = Rideable::with('location','rides')
            ->has('rides')
            ->whereHas('location', function($q) {
                $q->whereNotIn('name', ['IND','Online']);
                $q->where('type', 'Client');
            })
            ->where('shift',$shift)->where('delivery_date',$history)->get();
        $bodyShops = $assigned->pluck('location')->flatten()->unique();

        $stops = $warehouses->merge($bodyShops); // merging all stops
        $stops->all();

        $drivers = Driver::all();
        $rides = Ride::with('rideable','rideable.location')->where('delivery_date', $history)->where('shift', $shift)->get();
        return view('home',compact('warehouses','history','dt','shift','drivers','stops','rides','when','assigned'));
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

    public function version()
    {
        $appName = env('APP_NAME');
        $gitRevList = shell_exec("git rev-list --all --count");
        // $gitShortlog = shell_exec("git shortlog --pretty=format:'%h - (%ci) %s ' --abbrev-commit");
        $gitShortlog = shell_exec("git shortlog --pretty=format:'%h - (%ci) %s ' --abbrev-commit");
        Transaction::log(Route::getCurrentRoute()->getName(), Auth::user(),Auth::user());

        return view('log',compact('appName','gitRevList','gitShortlog'));
    }
}
