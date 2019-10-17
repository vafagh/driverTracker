<?php

namespace App\Http\Controllers;

use DateTime;
use Auth;
use App\Ride;
use App\User;
use App\Helper;
use App\Driver;
use App\Location;
use App\Rideable;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RideableController extends Controller
{
    public function list(Request $request, $type)
    {
        if($type == "delivery") { $op1 = 'Client';    $op2 = 'Delivery'; $operator = '=';  $orderColumn = 'created_at'; }
        else                    { $op1 = 'Warehouse'; $op2 = 'Pickup';   $operator = '!='; $orderColumn = 'location_id';}

        (empty($request->input('sortby'))) ? $rideableSort = $orderColumn: $rideableSort = $request->input('sortby');

        $fields = Helper::queryFiller($request,$type);

        $rideables = Rideable::with('user','rides','rides.driver','rides.truck','location')
        ->whereHas('location', function($q) use ($operator) {
            $q->where('type', $operator, 'Client');
        })
        ->whereIn('status', $request->filled('status') ? ['returned'] : Helper::filter('ongoing'))
        ->where([$fields['shift'], $fields['delivery_date']])
        ->orderBy($rideableSort, 'asc')
        ->paginate(120);
        ($request!==null) ? $flashId = $request->id : $flashId = '1';
        return view('rideable.rideables',compact('rideables','op1','op2','flashId'));
    }

    public function show(Rideable $rideable)
    {
        $pickup = ($rideable->type=='Pickup') ? true : false;
        return view('rideable.show',compact('rideable','pickup'));
    }

    public function map(Request $request)
    {
        $fields = Helper::queryFiller($request);
        $spots = Location::with('rideables')
        ->whereNotIn('name',['IND','Online'])
        // ->whereDoesntHave('rideables.rides')
        ->whereHas('rideables', function($q) use($fields){
            $q->whereIn('status', Helper::filter('ongoing'));
            $q->where([ $fields['shift'], $fields['delivery_date']]);
            $q->orWhere([
                ['type','=','Warehouse'],
                ['status', '!=', 'Done'],
                ['status', '!=', 'Canceled'],
                ['status', '!=', 'NotAvailable'],
            ]);
        });
        $spots = $spots->get();

        foreach ($spots as $key => $value) {
            Location::addGeo($value);
        }
        if(!empty($loc = $spots->firstWhere('lat',null)) || !empty($loc = $spots->firstWhere('lng',null))){
            return redirect()->action("LocationController@show", [$loc])->with('warning','Please Correct/Update the location address In order to draw the map. ');
        }

        $unassign = Rideable::with('location')
            ->doesntHave('rides')
            ->whereIn('status', Helper::filter('ongoing'))
            ->where([[$fields['delivery_date'][0],$fields['delivery_date'][1],$fields['delivery_date'][2]],[$fields['shift'][0],$fields['shift'][1],$fields['shift'][2]]])
            ->whereDoesntHave('location', function($q) { $q->where('name', 'IND');})
            ->get();

        $assigned = Rideable::with('location')
            ->has('rides')
            ->whereIn('status', Helper::filter('ongoing'))
            ->where([[$fields['delivery_date'][0],$fields['delivery_date'][1],$fields['delivery_date'][2]],[$fields['shift'][0],$fields['shift'][1],$fields['shift'][2]]])
            ->whereDoesntHave('location', function($q) { $q->where('name', 'IND');})
            ->get();
        return view('map',['spots' => $spots,'count' => $spots->count(),'unassign' => $unassign, 'cluster' => (filled($request->input('cluster'))) ? $request->input('cluster'): 0, 'assigned' => $assigned, 'delivery_date' => $fields['delivery_date'][2], 'shift' => $fields['shift'][2]]);
    }

    public function status(Request $request, $redirect=true)
    {
        $rideable = (isset((Rideable::find($request->rideable)->id))) ? Rideable::find($request->rideable) : Rideable::where('invoice_number' ,$request->rideable)->first();
        if($rideable != null){
            $rideable->status = $request->status;
            if($rideable->type !='Client'){
                $today = new Carbon;
                $rideable->delivery_date = $today->format('Y-m-d');
                $rideable->shift =  date('H:i');
            }
            if($request->status == 'Reschedule'){
                $location = $rideable->location;
                $location->driver_id = null;
                $location->save();
                $rideable->delivery_date    = Helper::when($rideable)['date'];
                $rideable->shift            = Helper::when($rideable)['shift'];
            }
            if($request->status == 'backOrdered'){
                $rideable->delivery_date    = $request->delivery_date;
                $rideable->shift            = $request->shift;
                $redirect = false;
            }

            Transaction::log(Route::getCurrentRoute()->getName(),Rideable::find($request->rideable),$rideable);
            $rideable->save();

            if($redirect) return redirect()->back()->with('status', $rideable->status.' set');
        }else {
            return redirect()->back()->with('status', 'Add ticket #'.$request->rideable.' and try again');

        }
    }

    // This function for inserting new invoices into system using excisting multiple line text from other systems.
    public function analyseRaw(Request $request)
    {
        // Sample acceptable raw data
        // 432975 │ 05/13/19 │ PAUL'SCOLL │ PAUL'S COLLISSION REPAIR    │         79.00
        // 432976 │ 05/13/19 │ FREEDOMAUT │ FREEDOM AUTO MOTORS(G.P.)   │         80.00
        // 432977 │ 05/13/19 │ IND        │ RENE                        │         27.06
        // 432978 │ 05/13/19 │ BUSY BODY  │ BUSY BODYS AUTO PAINTING    │         42.00

        // rawData will provided to next manual itaraion due to non javascrip blade
        $rawData = $request->rawData;
        // breaking each line to array row
        $rawInvoices=explode("\r\n",$request->rawData);
        $invoices= array();
        foreach ($rawInvoices as $key => $rawInvoice) {
            // each line is going be one row and each row will brake into multiple string(devided by | ), clean from extra white spaces and nested in parents array
            array_push($invoices,(array_map('trim',array_filter(explode(" │ ",$rawInvoice)))));
        }
        $n = 0;

        return view('rideable.batchConfirm', compact('invoices','rawData','n'));
    }

    public function store(Request $request)
    {
        $msg = '';
        for ($i=0,$j=0; $i <= $request->n ; $i++) {
            $exist = Rideable::where('invoice_number',$request->{"invoice_number$i"})->where('type','=','Client')->get()->count();
            // if($exist>0) return redirect()->back()->with('error', $request->{"invoice_number$i"}." is already in system!");
            if($exist>0){
                $msg = ' '.$request->{"invoice_number$i"}." is already in system! ";
            }else{
                $thisRequest = $request;
                if ($request->{"invoice_number$i"}!='' && isset($request->{"item_$i"}) ) {
                    $j++;
                    $rideable = new Rideable;
                    $rideable->user_id = Auth::id();
                    if($request->submitType!='batch') {
                        $thisRequest->{"locationName$i"} = $thisRequest->locationName0;
                        $thisRequest->{"locationPhone$i"} = $thisRequest->locationPhone0;
                    }
                    (is_null($request->{"locationName$i"})) ? $locationName = $thisRequest->{"locationPhone$i"} : $locationName = $thisRequest->{"locationName$i"};
                    $location = Location::where('name', $locationName)->first();
                    ($thisRequest->type == 'Delivery' && $location == null ) ? redirect()->back()->with('error', 'Location "'.$locationName.'" not exist. Please create it. '):"";
                    $rideable->location_id = $location->id;
                    $msg .= Location::addGeo($location);
                    $rideable->invoice_number = $request->{"invoice_number$i"};
                    ($request->{"stock$i"} == 'on') ? $rideable->stock = true :'';
                    $rideable->qty = $request->{"qty$i"};
                    $rideable->type = Location::find($rideable->location_id)->type;
                    $rideable->shift = empty($thisRequest->{"shift$i"}) ? $thisRequest->shift : $thisRequest->{"shift$i"} ;
                    $rideable->delivery_date = empty($thisRequest->{"delivery_date$i"}) ? $thisRequest->delivery_date : $thisRequest->{"delivery_date$i"} ;
                    if ($request->ready ==1 && $request->status == 'Pulled'&& filled($request->puller)) {
                        $rideable->status = 'Pulled';
                        $today = new Carbon;
                        $rideable->delivery_date = $today->format('Y-m-d');
                        $rideable->description = $request->description.' | Pulled By '.$request->input('puller').' at '.$today->format('Y-m-d').' '.date('H:i');
                    }else{
                        $rideable->status = 'Created';
                        $rideable->description = $thisRequest->description;
                    }
                    $rideable->save();
                    Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);
                }
            }
        }
        if($request->submitType=='batch' && !empty($rideable)) {
            $rawData = $request->rawData;
            $invoices=null;
            $n = 0;
            $msg .=" part number has been added and marked as a pulled! ";
            return view('rideable.batchConfirm', compact('invoices','rawData','n'))->with('status', $rideable->invoice_number.$msg.' ');
        }
        elseif($request->status == 'Pulled') {return redirect()->route('pull.rideable')->with('status', $j." part number has been added! ".' '.$msg);}
        else {return redirect()->route('rideables',['type'=>$request->type])->with('status', $j." part number has been added! ".' '.$msg);}

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

    public function batchUpdate(Request $request)
    {
        if ($request->input('which')=='unassigned') {
            $selectedTicket = Rideable::whereDoesntHave('rides')
                                        ->whereHas('location', function($q){
                                            $q->where('type', '=', 'Client');
                                        })
                                        ->whereNotIn('status', Helper::filter('finished'));
        }elseif ($request->input('which')=='all') {
            $selectedTicket = Rideable::whereHas('location', function($q){
                                            $q->where('type', '=', 'Client');
                                        })
                                        ->whereNotIn('status', Helper::filter('finished'));
        }

        $rideables = $selectedTicket->get();

        $selectedTicket->update(['delivery_date' =>  $request->input('newDelivery_date')]);
        $selectedTicket->update(['shift' =>  $request->input('newShift')]);

        $msg = '';
        foreach ($rideables as $key => $rideable) {
            Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);
            $msg .= $rideable->invoice_number.', ';
        }


        return redirect()->back()->with('status', $msg." Reschaduled!");
    }

    public function update(Request $request)
    {
        $rideable = Rideable::find($request->id);
        if(empty($request->onlyStatus)){
            $rideable->description = $request->description;
            $rideable->invoice_number = $request->invoice_number;
            // $rideable->type = $request->type; //user cant change the type
            ($request->stock == 'on') ? $rideable->stock = true :$rideable->stock = false;
            $rideable->qty = $request->qty;
            $rideable->shift = $request->shift;
            $rideable->delivery_date = $request->delivery_date;
            if($rideable->rides->count() > 0){
                foreach ($rideable->rides as $ride) {
                    $ride->shift = $request->shift;
                    $ride->delivery_date = $request->delivery_date;
                    $ride->save();
                }
                $msg = 'Ride date/shift updated';
            }
        }
        if(filled($request->puller)){
            $today = new Carbon;
            $rideable->delivery_date = $today->format('Y-m-d');
            $rideable->description = $rideable->description.' | '.$request->description.' | Pulled By '.$request->input('puller').' at '.$today->format('Y-m-d').' '.date('H:i');
        }
        $rideable->status = $request->status;
        $rideable->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$rideable);

        if (filled($request->puller)) {
            return  view('rideable.pull',['last' => substr(Rideable::latest()->get()->first()->invoice_number,0,-3), 'pickups' => Rideable::whereIn('status', Helper::filter('ongoing'))->whereHas('location', function($q) {$q->whereIn('name', ['IND','Online']);})->orderBy('invoice_number', 'asc')->get()])
                        ->with('status', '#'.$rideable->invoice_number." Marked as a pulled!");
        }else return redirect()->back()->with('status', '#'.$rideable->invoice_number." updated!");
    }

    public function destroy(Rideable $rideable,Request $request)
    {
        if(Auth::user()->id==$rideable->user_id || Auth::user()->role_id > 4){
            if($rideable->rides()->count() > 0){
                $rideable->rides()->detach();
                $driversName='';
                foreach (Ride::where('rideable_id',$rideable->id)->get() as $child) {
                    Ride::destroy($child->id);
                    $driversName .= $child->driver->fname.', ';
                }
                $msg = 'attached ride destroyed { '.$driversName.'}';
            }else{ $msg = 'no attached ride to destroy!';}
            Rideable::destroy($rideable->id);
            Transaction::log(Route::getCurrentRoute()->getName(),$rideable,false);

            return redirect()->back()->with('status', 'Rideable Destroid! and '.$msg);
        }

        return redirect()->back()->with('status', 'Access Denied. '.$rideable->user->name.' created it and only one who can destroy it!');
    }

    public function pull()
    {
        return view('rideable.pull',['last' => substr(Rideable::latest()->get()->first()->invoice_number,0,-3),
            'pickups' => Rideable::whereIn('status', Helper::filter('ongoing'))
                ->whereHas('location', function($q) {$q->whereIn('name', ['IND','Online']);})
                ->orderBy('invoice_number', 'asc')
                ->get()
            ]);
    }

    public function updateOrInsert(Request $request)
    {
        $rideable = Rideable::with('location')->where('invoice_number','=',$request->invoice_number)->get();
        if ($rideable->count() == 0 && $request->ready != 1) {
            $request->request->add(['invoice_number0' => $request->invoice_number ,'qty' => '','showForm' => 'yes','stored' => 'no','item_0' => 'on']);
            return view('rideable.pull',['last' => $request->invoice_number,'request' => $request,'update' => false]);
        }elseif($request->ready == 1){
            $this->store($request);
        }else{
            $rideable = $rideable->first();
            $request->request->add(['invoice_number0' => $rideable->invoice_number ,'qty' => '','showForm' => 'yes','stored' => 'yes','item_0' => 'on']);
            return view('rideable.pull',['last' => $rideable->invoice_number,'request' => $request,'rideable' => $rideable,'update' => true]);
        }
    }


}
