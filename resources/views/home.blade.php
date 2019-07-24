@extends('layouts.app')

@section('content')

    <div class="bg-secondary  d-flex justify-content-around my-2">
        <div class="right text-center">
            <a class="text-light" title="Today" href="/"><i class="material-icons">today</i></a>
            <a class="text-light" title="Go one Months backward" href="/?history={{$dt->copy()->submonths(1)->format('Y-m-d')}}&shift={{$shift}}&shift={{$shift}}"><i class="material-icons">fast_rewind</i></a>
            <a class="text-light" title="Go one Weeks backward" href="/?history={{$dt->copy()->subWeeks(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons">skip_previous</i></a>
            <a class="text-light" title="Go one Days backward" href="/?history={{$dt->copy()->subDays(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons">keyboard_arrow_left</i></a>
            <a class="op-04 mor d-inline-block{{$shift == 'Morning' ? ' op-1' :''}}" title="morning" href="/?history={{$history}}&shift=Morning"><span>Morning</span></a>
            @php
                $shift=='Morning' ? $dt->addHours(9) : $dt->addHours(13);
            @endphp
            <span class="h4 lh-15 text-light">{{$dt->format('l jS \\of F Y')}} </span> <span class="h4 text-bold text-warning">{{$shift}}</span>
            <a class="op-04 eve d-inline-block{{$shift == 'Evening' ? ' op-1' :''}}" title="evening" href="/?history={{$history}}&shift=Evening"><span>Evening</span></a>
            <a class="text-light" title="Go one Days forward" href="/?history={{$dt->copy()->addDays(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons">keyboard_arrow_right</i></a>
            <a class="text-light" title="Go one Weeks forward" href="/?history={{$dt->copy()->addWeeks(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons">skip_next</i></a>
            <a class="text-light" title="Go one Months forward" href="/?history={{$dt->copy()->addmonths(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons">fast_forward</i></a>
        </div>
    </div>
    <div class="pickups card">
        <div class="card-header bg-primary text-light d-flex justify-content-between">
            <span class="p-0 m-0">Pickups by locations</span>
            <div class="create ">
                @component('layouts.components.modal',['modelName'=>'rideable','action'=>'create','iterator'=>0,'object'=>null,'op1'=>'Warehouse','op2'=>'Pickup','style' => 'p-0 m-0','dingbats'=>'<i class="material-icons">add_box</i>','autocomplateOff'=>true])
                @endcomponent
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($warehouses as $key => $warehouse)
                    <div class="card col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3{{--App\Helper::col($warehouses->count())--}} mb-4 ml-1 p-0">
                        <div class="card-header text-center mh-20 px-0d-flex justify-content-around">
                            @component('layouts.components.tooltip',['modelName'=>'location','model'=>$warehouse])
                            @endcomponent
                            @if (Auth::user()->role_id > 3)
                                <small class="text-muted">
                                    Total trip :{{ App\Rideable::where('location_id', $warehouse->id)->count() }}
                                </small>
                            @endif
                        </div>
                        @php
                            $rideables = ($history == $dates['today']) ? $warehouse->rideables->where('delivery_date',$history)->merge($warehouse->rideables->where('delivery_date',null))->all() : $warehouse->rideables->where('delivery_date',$history)
                        @endphp
                        <div class="card-body p-0">
                            @foreach ($rideables as $key => $rideable) {{-- ->whereIn('status',['Created','OnTheWay','NotAvailable','DriverDetached'])--}}
                                <div class="row {{$rideable->status}} m-0 p-0 text-uppercase border-bottom mb-1">
                                    <div class="InvoiceNumber col-7 line text-truncate px-0">
                                        <div class="font-70">
                                            @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                                                <div class="d-inline pl-1">
                                                    @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','object'=>$rideable,'iterator'=>$key,'op1'=>$rideable->type,'op2'=>'','dingbats'=>'<i class="material-icons md-16">edit</i>','style'=>'text-info pr-0','file'=>false,'autocomplateOff'=>true])
                                                    @endcomponent
                                                </div>
                                            @endif
                                            <div class="InvoiceNumber fixedWidthFont d-inline {{$rideable->status == 'Done' ? 'line-through':''}}"  title="{{$rideable->created_at}}">
                                                @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action col-5 line p-0 text-right pr-2">
                                        <div class="showOnHover">
                                            @if ($rideable->status=='Done')
                                                <div class="mt-1">
                                                    {{($rideable->user->name)}}
                                                </div>
                                            @else
                                                @component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'iterator' => $rideable->id,'op1'=>'Warehouse','op2'=>'Pickup'])
                                                @endcomponent
                                            @endif
                                        </div>
                                        <div class="hideOnHover">
                                            <div class="mt-1">
                                            @if ($rideable->status=='Done')
                                                rec.on {{$rideable->shift}}
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
                                        Pickup by: {{$defDriver_fname}}
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
                                    @endif
                                    <a href='/drivers' title="Assign Driver To Track">
                                        <i class="material-icons md-14">person_add</i>
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="drivers card mt-4">
        <div class="card-header">Today's ride by driver</div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($drivers as $key => $driver)
                    @php
                        $when = [$history,$shift];
                        // $rides = App\Ride::with('rideable','rideable.location')->where([['shift',$when[1]],['delivery_date',$when[0]],['driver_id',$driver->id]])->get();
                        // $deliveryStops = $rides->pluck('rideable.location')->flatten()->unique();
                        $deliveryStops = $stops->pluck('rideable.rides')->flatten()->where('driver_id',$driver->id);
                    @endphp

                    <div class="card col-6 col-sm-4 col-md-3 col-lg-2 px-0 {{($deliveryStops->count() > 0) ? '' : 'd-none' }}">
                        <div class="card-header pt-1 pb-1 d-flex justify-content-between">
                            @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$driver])
                            @endcomponent
                            <span class='text-bold'>{{$shift}}</span>
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
                            <ol>
                            @foreach ($deliveryStops as $key => $location)
                                {{-- @foreach ($value as $key => $location) --}}
                                    @if (!empty($location->id))
                                        @php
                                            // $location = empty($stop->rideable->location)? $stop : $stop->rideable->location;
                                            $markers .= 'markers=size:tiny%7Ccolor:red%7Clabel:'.$location->id.'%7C'.$location->lat.','.$location->lng.'&';
                                            $latsum = $latsum + $location->lat;
                                            $lngsum = $lngsum + $location->lng;
                                            $stopcount++;
                                        @endphp
                                        <li class="fixedWidthFont">
                                            <a class="{{$location->type=='Client' ? 'text-success' : 'text-info'}}" title="{{$location->name}}" href="/location/show/{{$location->id}}">
                                                {{$location->longName}}
                                            </a>
                                        </li>
                                    @endif
                                {{-- @endforeach --}}
                            @endforeach
                            </ol>
                        </div>
                        <div class="card-image overflow-hidden text-center">
                            @if ($stopcount!=0)
                                <a href="/driver/{{$driver->id}}/{{$history}}/{{$shift}}/direction">
                                    <img class="mx-auto d-block" src="https://maps.googleapis.com/maps/api/staticmap?center={{$latsum/$stopcount}},{{$lngsum/$stopcount}}&zoom=9&size=250x200&maptype=roadmap&{{$markers}}&key={{env('GOOGLE_MAP_API')}}" alt="routes">
                                </a>
                            @endif
                        </div>
                        <div class="card-footer row statistic font-70">
                            <small class=" col-12 text-muted pm-0">
                                DeliveryTrip Counter : from total of
                                 @php
                                    $driverAllRides = App\Ride::where('driver_id', $driver->id)
                                                                ->whereHas('rideable', function($q){
                                                                    $q->where('type','=','Client');
                                                                });
                                    $lengthOfWork = $driverAllRides->first()->created_at->diffInDays($dates['today'])
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
    </div>
    <div class="card stops">
        <div class="card-header">
            {{$stops->count()}}
        </div>
        <div class="card-image ">
            @php
                $markers = ''; $latsum =0; $lngsum=0; $stopcount=0;
            @endphp
            {{-- <ol> --}}

                @foreach ($stops as $key => $stop)
                    @php
                    $markers .= 'markers=size:tiny%7Ccolor:red%7Clabel:'.$stop->id.'%7C'.$stop->lat.','.$stop->lng.'&';
                    $latsum = $latsum + $stop->lat;
                    $lngsum = $lngsum + $stop->lng;
                    $stopcount++;
                    @endphp
                    {{-- <li>{{$stop->name}}
                        <ul>
                            @foreach ($stop->rideables->where('shift',$shift)->where('delivery_date',$history) as $key => $ticket)
                                <li>{{$ticket->invoice_number}}
                                    @foreach ($ticket->rides as $key => $ride)
                                        {{$ride->driver->fname}}
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </li> --}}
                @endforeach
            {{-- </ol> --}}
            @if ($stopcount>0)
                <img class="mx-auto d-block" src="https://maps.googleapis.com/maps/api/staticmap?center={{$latsum/$stopcount}},{{$lngsum/$stopcount}}&zoom=9&size=1200x300&maptype=roadmap&{{$markers}}&key={{env('GOOGLE_MAP_API')}}" alt="routes">
            @endif
        </div>
    </div>
@endsection
