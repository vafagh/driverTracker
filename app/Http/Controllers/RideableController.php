<?php

namespace App\Http\Controllers;

use DateTime;
use Auth;
use App\Rideable;
use App\Ride;
use App\Location;
use App\Driver;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RideableController extends Controller
{
    public function map(Request $request)
    {
        $yesterNoon = Carbon::yesterday()->addHours(13);
        $todayMorning = Carbon::today()->addHours(9);
        $todayNoon = Carbon::today()->addHours(13);
        $tomarowMorning = Carbon::today()->addDay(1)->addHours(9);
        $shift = $request->input('shift');
        if ($shift == 'first') {
            $start = $yesterNoon;
            $end = $todayMorning;
        }
        elseif($shift == 'second'){
            $start = $todayMorning;
            $end = $todayNoon;
        }
        elseif($shift == 'tomarow'){
            $start = $todayNoon;
            $end = $tomarowMorning;
        }
        else{
            $start = Carbon::today()->subYear(1);
            $end = Carbon::today()->addYear(1);
        }

        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
            // ->whereHas('rides')
            ->where([
                ['status', '!=', 'Done'],
                ['status', '!=', 'Canceled'],
                ['status','!=','Returned'],
                ['created_at','>=',$start],
                ['created_at','<=',$end]
            ])
            ->orderBy('location_id', 'desc')
            ->get();
        $count= $rideables->count();
        $activeDrivers = Driver::where('truck_id','!=',null)->get();
        return view('map',compact('rideables','activeDrivers','count'));
    }

    public function show(Rideable $rideable)
    {
        return view('rideable.show',compact('rideable','clients'));
    }

    public function list(Request $request, $type)
    {
        if($type == "delivery") { $op1 = 'Client';    $op2 = 'Delivery'; $operator = '=';  $orderColumn = 'invoice_number'; }
        else                    { $op1 = 'Warehouse'; $op2 = 'Pickup';   $operator = '!='; $orderColumn = 'location_id';}
        (empty($request->input('sortby'))) ? $rideableSort = $orderColumn: $rideableSort = $request->input('sortby');
        $yesterNoon = Carbon::yesterday()->addHours(13);
        $todayMorning = Carbon::today()->addHours(9);
        $todayNoon = Carbon::today()->addHours(13);
        $tomarowMorning = Carbon::today()->addDay(1)->addHours(9);
        $shift = $request->input('shift');
        if ($shift == 'first') {
            $start = $yesterNoon;
            $end = $todayMorning;
        }
        elseif($shift == 'second'){
            $start = $todayMorning;
            $end = $todayNoon;
        }
        elseif($shift == 'tomarow'){
            $start = $todayNoon;
            $end = $tomarowMorning;
        }
        else{
            $start = Carbon::today()->subYear(1);
            $end = Carbon::today()->addYear(1);
        }

        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
            ->whereHas('location', function($q) use ($operator) {
                $q->where('type', $operator, 'Client');
            })
            ->where([
                ['status','!=','Done'],
                ['status','!=','Canceled'],
                // ['status','!=','NotAvailable'],
                ['status','!=','Returned'],
                ['created_at','>=',$start],
                ['created_at','<=',$end]
            ])
            ->orderBy($rideableSort, 'desc')
            ->paginate(70);
            // dd('this is report for "'.$shift.'" between '.$start.' and '.$end);

        ($request!==null) ? $flashId = $request->id : $flashId = '1';

        return view('rideable.rideables',compact('rideables','op1','op2','flashId'));
    }

    public function status(Request $request)
    {
        $rideable=Rideable::find($request->rideable);
        $rideable->status = $request->status;
        Transaction::log(Route::getCurrentRoute()->getName(),Rideable::find($request->rideable),$rideable);
        $rideable->save();

        return redirect()->back()->with('status', $rideable->status.' set');
    }

    public function store(Request $request)
    {
        for ($i=0,$j=0; $i < 10 ; $i++) {
            $thisRequest = $request;
            if ($request->{"invoice_number$i"}!='') {
                $j++;
                $rideable = new Rideable;
                $rideable->user_id = Auth::id();
                (is_null($request->locationName)) ? $locationName = $thisRequest->locationPhone : $locationName = $thisRequest->locationName;
                if($thisRequest->type=='Delivery'){
                    if(Location::where('longName', $locationName)->first()==null) {return redirect()->back()->with('error', 'Location "'.$locationName.'" not exist. Make sure you select it from list. ');}
                    else{$rideable->location_id = Location::where('longName', $locationName)->first()->id;}
                }else{
                    $rideable->location_id = $locationName;
                }
                $msg = Location::addGeo(Location::find($rideable->location_id));
                $rideable->invoice_number = $request->{"invoice_number$i"};
                ($request->{"stock$i"} == 'on') ? $rideable->stock = true :'';
                $rideable->qty = $request->{"qty$i"};
                $rideable->type = Location::find($rideable->location_id)->type;
                $rideable->shift = $request->shift;
                $rideable->delivery_date = $request->delivery_date;
                $rideable->status = 'Created';
                $rideable->description = $thisRequest->description;
                $rideable->save();
                Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);
            }
        }

        return redirect()->back()->with('status', $j." part number has been added! ".' '.$msg);
        // return redirect()->back()->with('status', '#'.$rideable->invoice_number." added! ".$msg);

    }

    public function batchStore(Request $request)
    {
        for ($i=0,$j=0; $i < 10 ; $i++) {
            $thisRequest = $request;
            $thisRequest->request->add(['invoice_number', $request->{"invoice_number$i"} ]);
            $thisRequest->request->add(['qty', $request->{"qty$i"} ]);
            $thisRequest->request->add(['stock', $request->{"stock$i"} ]);
            if ($thisRequest->invoice_number!=null) {
                $this->store($thisRequest);
                $j++;
            }
        }
    }

    public function update(Request $request)
    {
        $rideable = Rideable::find($request->id);
        // belowe line is commentet to preserve the original creator.
        // $rideable->user_id = Auth::user()->id;
        $rideable->invoice_number = $request->invoice_number;
        // $rideable->type = $request->type;
        ($request->stock == 'on') ? $rideable->stock = true :$rideable->stock = false;
        $rideable->qty = $request->qty;
        $rideable->status = $request->status;
        $rideable->description = $request->description;
        $rideable->shift = $request->shift;
        $rideable->delivery_date = $request->delivery_date;
        $rideable->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);

        return redirect()->back()->with('status', '#'.$rideable->invoice_number." updated!");

    }

    public function destroy(Rideable $rideable,Request $request)
    {
            if(Auth::user()->id==$rideable->user_id){
                if($rideable->rides()->first()!=null){
                    $ride_id = $rideable->rides()->first()->id;
                    $rideable->rides()->detach($ride_id);
                    Ride::destroy($ride_id);
                }
                Rideable::destroy($rideable->id);
                Transaction::log(Route::getCurrentRoute()->getName(),$rideable,false);

                return redirect()->back()->with('status', 'Rideable Destroid!');
            }

        return redirect()->back()->with('status', 'Access Denied. You are not the one '.$rideable->user->name.' who created it!');
    }
}
