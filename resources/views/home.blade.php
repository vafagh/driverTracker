@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-around">
        <div class="right text-center">
            <a class="text-warning" title="Go one Months backward" href="/?history={{$dt->copy()->submonths(1)->format('Y-m-d')}}&shift={{$shift}}&shift={{$shift}}"><i class="material-icons top-m2 top-m2">fast_rewind</i></a>
            <a class="text-warning" title="Go one Weeks backward" href="/?history={{$dt->copy()->subWeeks(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">skip_previous</i></a>
            <a class="text-warning" title="Go one Days backward" href="/?history={{$dt->copy()->subDays(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">keyboard_arrow_left</i></a>
            <a class="op-04 mor d-inline-block{{$shift == 'Morning' ? ' op-1' :''}}" title="morning" href="/?history={{$history}}&shift=Morning"><span>Morning</span></a>
            <a class="text-success" title="Today" href="/"><i class="material-icons top-m2">today</i></a>
            @php
                $shift=='Morning' ? $dt->addHours(9) : $dt->addHours(13);
            @endphp
            {{-- <span class="h4 lh-15 text-info">{{$dt->format('l jS \\of F Y')}} </span> <span class="h4 text-bold text-warning">{{$shift}}</span> --}}
            <a class="op-04 eve d-inline-block{{$shift == 'Evening' ? ' op-1' :''}}" title="evening" href="/?history={{$history}}&shift=Evening"><span>Evening</span></a>
            <a class="text-info" title="Go one Days forward" href="/?history={{$dt->copy()->addDays(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">keyboard_arrow_right</i></a>
            <a class="text-info" title="Go one Weeks forward" href="/?history={{$dt->copy()->addWeeks(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">skip_next</i></a>
            <a class="text-info" title="Go one Months forward" href="/?history={{$dt->copy()->addmonths(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">fast_forward</i></a>
        </div>
    </div>

    <div class="pickups card">
        <div class="card-header bg-primary text-light d-flex justify-content-between pb-0">
            <span class="p-0 m-0">Back-Orders by locations</span>
            <span class="p-0 m-0"><span class=" h4 text-light">{{$dt->format('l jS \\of F Y')}} </span> <span class="h4 text-bold text-warning">{{$shift}}</span></span>
            <div class="create mt-0">
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'action'=>'create',
                    'op1'=>'Warehouse',
                    'op2'=>'Pickup',
                    'style' => 'p-0 m-0',
                    'dingbats'=>'<i class="material-icons">add_box</i>',
                    'autocomplateOff'=>true])
                @endcomponent
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'action'=>'batch',
                    'dingbats'=>'<i class="material-icons">playlist_add</i>',
                    'autocomplateOff'=>true])
                @endcomponent
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'name'=>'negatives',
                    'action'=>'button',
                    'dingbats'=>'<i class="material-icons">exposure_neg_1</i>',
                    'autocomplateOff'=>true])
                @endcomponent
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($warehouses as $key => $warehouse)
                    <div class="card col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3{{--App\Helper::col($warehouses->count())--}} mb-4 ml-1 p-0 {{($warehouse->name == 'Other') ? ' border border-warning':''}}">
                        <div class="card-header text-center mh-20 px-0d-flex justify-content-around">
                            @component('layouts.components.tooltip',['modelName'=>'location','model'=>$warehouse])
                            @endcomponent
                        </div>
                        @php
                            $rideables = ($history == $dates['today']) ? $warehouse->rideables->where('delivery_date',$history)->merge($warehouse->rideables->where('delivery_date',null))->all() : $warehouse->rideables->where('delivery_date',$history)
                        @endphp
                        <div class="card-body p-0">
                            @foreach ($rideables as $key => $rideable)
                                <div class="row m-0 p-0 text-uppercase border-bottom mb-1 {{($rideable->location->name == 'Other') ?  (($rideable->user->name==Auth::user()->name) ? "": " text-muted mark "):$rideable->status }}">
                                    <div class="InvoiceNumber col-7 line text-truncate px-0">
                                        <div class="font-70">
                                            @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                                                <div class="d-inline pl-1">
                                                    @component('layouts.components.modal',['modelName'=>'rideable', 'action'=>'edit', 'object'=>$rideable, 'iterator'=>$rideable->id+$key, 'op1'=>$rideable->type, 'op2'=>'', 'dingbats'=>'<i class="material-icons md-16">edit</i>', 'style'=>'text-info pr-0','file'=>false,'autocomplateOff'=>true])
                                                    @endcomponent
                                                </div>
                                            @endif
                                            @php
                                            $ticket = App\Rideable::where('invoice_number',$rideable->description)->first();
                                            @endphp
                                            <div class="InvoiceNumber fixedWidthFont d-inline  {{$rideable->status == 'Done' || $rideable->status == 'Canceled'||$rideable->status == 'NoData' ? 'line-through':''}}"  title="{{$rideable->created_at}}">
                                                @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                                @endcomponent
                                                <span class="small">
                                                    {{$ticket->location->name ??''}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action col-5 line p-0 text-right pr-2">
                                        <div class="showOnHover text-truncate">
                                            @if ($rideable->status=='Done')
                                                <div class="mt-1">
                                                    {{($rideable->user->name)}}
                                                </div>
                                            @else
                                                @component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'iterator' => $rideable->id,'op1'=>'Warehouse','op2'=>'Pickup'])
                                                @endcomponent
                                            @endif
                                        </div>
                                        <div class="hideOnHover ">
                                            <div class="mt-1 text-truncate">
                                            @if ($rideable->status=='Done')
                                                &#64;{{$rideable->shift}} received
                                            @elseif($rideable->status=='Canceled')
                                                &copf; {{$rideable->status}}
                                            @elseif($rideable->status=='NoData')
                                                <i class="material-icons md-14">wifi_off</i> {{$rideable->status}}
                                            @else
                                                {{($rideable->user->name)}}
                                            @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer p-0">
                            @if ($warehouse->type=='DropOff')
                                <div class="px-3  text-muted "> Drop Off</div>
                            @else
                                @php
                                $defDriver = App\Driver::find($warehouse->driver_id);
                                $defDriver_fname = (empty($defDriver->fname)) ? null: $defDriver->fname;
                                @endphp
                                <span class="text-muted font-80">
                                    @if (empty($defDriver))
                                        Not assigned yet
                                    @else
                                        Picking by: {{$defDriver_fname}}
                                    @endif
                                </span>
                                <div class="d-flex justify-content-around px-1" id="heading{{$warehouse->id}}">
                                </div>
                                <div>
                                    @if (Auth::user()->role_id >= 3)
                                        @foreach ($activeDrivers as $key => $driver)
                                            <a  class="{{($driver->fname==$defDriver_fname)? "":"disable"}} rounded-circle" href='/location/{{$warehouse->id}}/driver/{{$driver->id}}' title="{{$driver->fname}}">
                                                <img src="/img/driver/small/{{strtolower($driver->fname)}}.png" alt="{{$driver->fname}}">
                                            </a>
                                        @endforeach
                                        <a href='/drivers' title="Assign Driver To Track">
                                            <i class="material-icons md-14">person_add</i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
<div class="drivers card my-4">
        @if ($assigned->count()>0)
            <div class="card-header bg-info">Drivers {{$shift}} ride </div>
            <div class="card-body text-dark">
                <div class="row d-flex justify-content-around">
                    @foreach ($drivers as $key => $driver)
                        @php
                            $thisDayRides = App\Ride::with('rideable','rideable.location')->where([['shift',$when[1]],['delivery_date',$when[0]],['driver_id',$driver->id]])->get();
                            // $deliveryStops = $thisDayRides->pluck('rideable.location')->flatten()->unique();
                            $deliveryStops = $thisDayRides->pluck('rideable.location')->unique();
                            $stopsAddress = App\Location::stylize(null,'store').'/';
                        @endphp

                        <div class="card col-6 col-sm-4 col-md-3 col-lg-2 px-0 {{($deliveryStops->count() > 0) ? '' : 'd-none' }}">
                            <div class="card-header pt-1 pb-1 d-flex justify-content-between">
                                <i class="material-icons" style='color:{{substr($driver->color,1,1)=='x' ? '#'.substr($driver->color,2):$driver->color}}'>person_pin</i>
                                <a href="/driver/show/{{$driver->id}}">{{$driver->fname}}</a>
                                {{-- <span class='text-bold'>{{$shift}}</span> --}}
                                @if ($driver->fname != 'Pickup')
                                    <div class="">
                                        <a href="/driver/{{$driver->id}}/{{$history}}/{{$shift}}/direction" > {{-- class='text-success tooltip-toggle' data-tooltip='{{$deliveryStops->count()}} Direction'> --}}
                                            <i class="material-icons md-16">directions</i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body  px-1">
                                @php
                                    $markers = ''; $latsum =0; $lngsum=0; $stopcount=0;
                                @endphp
                                <ol class="p-0 pl-4">
                                @foreach ($deliveryStops as $key => $location)
                                    {{-- @foreach ($value as $key => $location) --}}
                                        @if (!empty($location->id))
                                            @php
                                                // $location = empty($stop->rideable->location)? $stop : $stop->rideable->location;
                                                $markers .= 'markers=size:tiny%7Ccolor:red%7Clabel:'.$location->id.'%7C'.$location->lat.','.$location->lng.'&';
                                                $latsum = $latsum + $location->lat;
                                                $lngsum = $lngsum + $location->lng;

                                                $stopcount++;
                                                $stopsAddress .= App\Location::stylize($location).'/';
                                            @endphp
                                            <li class="fixedWidthFont">
                                                <a class="text-truncate {{$location->type=='Client' ? 'text-success' : 'text-info'}}" title="{{$location->name}}" href="/location/show/{{$location->id}}">
                                                    {{$location->longName}}
                                                </a>
                                            </li>
                                        @endif
                                    {{-- @endforeach --}}
                                @endforeach
                                </ol>
                                <a
                                    {{-- {{$stopcount!=0 ? '
                                                        onmouseover="
                                                            loadStatImg(
                                                                https://maps.googleapis.com/maps/api/staticmap?center='.$latsum/$stopcount.','.$lngsum/$stopcount.'&zoom=9&size=250x200&maptype=roadmap&'.$markers.'&key='.env('GOOGLE_MAP_API').',
                                                            )
                                                        "
                                                    ':''}}
                                    target="_blank" --}}
                                    href="https://www.google.com/maps/dir/{{$stopsAddress}}{{App\Location::stylize(null,'store')}}">Dir</a>
                            </div>
                            {{-- <div class="card-image overflow-hidden text-center">
                                @if ($stopcount!=0)
                                    <a href="/driver/{{$driver->id}}/{{$history}}/{{$shift}}/direction">
                                        <img class="mx-auto d-block" src="https://maps.googleapis.com/maps/api/staticmap?center={{$latsum/$stopcount}},{{$lngsum/$stopcount}}&zoom=9&size=250x200&maptype=roadmap&{{$markers}}&key={{env('GOOGLE_MAP_API')}}" alt="routes">
                                    </a>
                                @endif
                            </div> --}}
                            <div class="card-footer row statistic font-70 m-0 p-2">
                                <small class=" col-12 text-muted pm-0">
                                    DeliveryTrip Counter : from total of
                                     @php
                                        $driverAllRides = App\Ride::where('driver_id', $driver->id)
                                                                    ->whereHas('rideable', function($q){
                                                                        $q->where('type','=','Client');
                                                                    });
                                        if ($driverAllRides->count()>0) {
                                            $lengthOfWork = $driverAllRides->first()->created_at->diffInDays($dates['today']);
                                        }
                                     @endphp
                                    {{ $allRidesCount = $driverAllRides->count() }}
                                </small>
                                <div class="col-3 pm-0">
                                    <div>
                                        {{ $driverAllRides->where("delivery_date",$dates['today'])->count() }}
                                    </div>
                                    <div>Today</div>
                                </div>
                                <div class="col-3 pm-0">
                                    <div>{{ App\Ride::where('driver_id', $driver->id)->whereDate("delivery_date",">",$dates['firstDayOfWeek'])->whereDate("delivery_date","<=",$dates['today'])->count() }}</div>
                                    <div>L.Week</div>
                                </div>
                                <div class="col-3 pm-0">
                                    <div>{{ App\Ride::where('driver_id', $driver->id)->whereDate("delivery_date",">",$dates['firstDayOfMonth'])->whereDate("delivery_date","<=",$dates['today'])->count() }}</div>
                                    <div>L.Month</div>
                                </div>
                                <div class="col-3 pm-0">
                                    {{-- <div>{{  $lengthOfWork  }}</div> --}}
                                    {{-- <div>{{ App\Ride::where('driver_id', $driver->id)->first()->created_at,1 }} /day</div> --}}
                                    <div>{{ ($lengthOfWork>0)? round($allRidesCount/$lengthOfWork,1) : '!' }} /day</div>

                                    <div>Average</div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        @else
            <div class="card-header bg-danger text-light">Rides for {{$shift}} not added yet! </div>
        @endif
    </div>

@if ($rides->count()>0)
    <div class="card stops ">
        <div class="card-header bg-teal">
            Stops on map
        </div>
        <div class="card-image ">
            {{-- {{dd($rides)}} --}}
                    @php
                    $markers = ''; $latsum =0; $lngsum=0; $stopcount=0;
                    @endphp
                    @foreach ($rides as $key => $ride)
                        @php
                        $stop = $ride->rideable->location;
                        $markers .= 'markers=size:medium%7Ccolor:'.$ride->driver->color.'%7Clabel:'.substr($stop->name,0,1).'%7C'.$stop->lat.','.$stop->lng.'&';
                        $latsum = $latsum + $stop->lat;
                        $lngsum = $lngsum + $stop->lng;
                        $stopcount++;
                        @endphp
                    @endforeach
                    @if ($stopcount>0)
                        <div class="">
                            @php
                                $index = null;
                                foreach ($activeDrivers as $key => $driver){
                                    $index .= '<span class="text-'.$driver->color.' font-weight-bold"> '.$driver->fname.' </span>';
                                }
                            @endphp
                            <div class="pl-4">{!!$index!!}</div>
                            <img class="mx-auto d-block" src="https://maps.googleapis.com/maps/api/staticmap?center=32.82,-97.00&zoom=9&size=640x450&maptype=roadmap&{{$markers}}&key={{env('GOOGLE_MAP_API')}}" alt="routes">
                            <div class="pl-4">{!!$index!!}</div>
                        </div>
                        {{-- <img class="mx-auto d-block" src="https://maps.googleapis.com/maps/api/staticmap?center={{$latsum/$stopcount}},{{$lngsum/$stopcount}}&zoom=9&size=640x500&maptype=roadmap&{{$markers}}&key={{env('GOOGLE_MAP_API')}}" alt="routes"> --}}
                    @endif
        </div>
    </div>
@endif
@endsection
