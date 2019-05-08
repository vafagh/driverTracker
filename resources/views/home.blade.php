@extends('layouts.app')

@section('content')

    <div class="locations card">
        <div class="card-header bg-primary text-light d-flex justify-content-between">
            <div class="">
                Pickups by locations on {{$history}}
                <br>
                {{(isset($sql))?$sql:''}}
            </div>
            <div class="create">
                @component('layouts.components.modal',['modelName'=>'rideable','action'=>'create','iterator'=>0,'object'=>null,'op1'=>'Warehouse','op2'=>'Pickup','style' => '','dingbats'=>'<i class="material-icons">add_box</i>','autocomplateOff'=>true])
                @endcomponent
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($warehouses as $key => $warehouse)
                    @php
                          // $rideables = ($history==$dates['today']) ? $warehouse->rideables->whereIn('status',['Created','Done']) : $rideables = $warehouse->rideables->whereIn('delivery_date',$history);
                         if($history==$dates['today']) {
                              $rideables = $warehouse->rideables->whereIn('status',['Created']);
                              // $rideables1 = $warehouse->rideables->whereIn('delivery_date', $dates['today']);
                              // $rideables = $rideables0->merge($rideables1);
                          }else $rideables = $warehouse->rideables->whereIn('delivery_date',[$history]);

                        // $rideables->all();
                    @endphp
                    <div class="card col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2{{--App\Helper::col($warehouses->count())--}} mb-4 ml-1 p-0">
                        <div class="card-header text-center mh-20 px-0d-flex justify-content-around">
                            @component('layouts.components.tooltip',['modelName'=>'location','model'=>$warehouse])
                            @endcomponent
                            @if (Auth::user()->role_id > 3)
                                <small class="text-muted">
                                    Total trip :{{ App\Rideable::where('location_id', $warehouse->id)->count() }}
                                </small>
                            @endif
                        </div>

                        <div class="card-body p-0">
                            @foreach ($rideables as $key => $rideable)
                                <div class=" d-flex justify-content-between {{$rideable->status}} px-1 text-uppercase mb-1">
                                    <div class="InvoiceNumber line ">
                                        <span class="font-80">
                                            {{-- {{$rideable->invoice_number}} --}}
                                            @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                                                <span class=" d-inline  ">
                                                    @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','dingbats'=>'<i class="material-icons md-16">edit</i>','style'=>'text-info pr-0','iterator'=>$key,'object'=>$rideable,'op1'=>$rideable->type,'op2'=>'','file'=>false,'autocomplateOff'=>true])
                                                    @endcomponent
                                                </span>
                                            @endif
                                            <span class="InvoiceNumber fixedWidthFont d-inline">
                                                @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                                @endcomponent
                                            </span>
                                        </span>
                                    </div>
                                    <div class="action line">
                                        <span class="showOnHover">
                                            {{$rideable->user->name}}
                                            @component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'object' => $rideable,'iterator' => $key,'op1'=>'Warehouse','op2'=>'Pickup'])
                                            @endcomponent
                                        </span>
                                        <span class="hideOnHover font-90">
                                            {{($rideable->status)}}
                                        </span>

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
                                <span class="text-muted progress">
                                    @if (empty($defDriver))
                                        Not assigned yet
                                    @else
                                        Pickup by: {{$defDriver_fname}}
                                    @endif
                                </span>
                                <div class="d-flex justify-content-around px-1" id="heading{{$warehouse->id}}">
                                </div>
                                <div>
                                    @if (Auth::user()->role_id = 3)
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
                @foreach ($activeDrivers as $key => $driver)
                    @php
                        $totalRides = App\Ride::where('driver_id',$driver->id)->whereDate('created_at', '=', $dates['today'])->get();
                    @endphp

                    <div class="card col-6 col-sm-4 col-md-3 col-lg-2 px-0 {{$totalRides->count() > 0 ? '' : 'd-none' }}">
                        <div class="card-header text-center mh-20 px-0 py-1 ">
                            @component('layouts.components.tooltip',
                            ['modelName'=>'driver','model'=>$driver])@endcomponent
                        </div>

                        <div class="card-body">
                            @foreach ($totalRides as $key => $rides)
                                @if (isset($rides->rideable))
                                    @if ($rides->rideable->status !='Done')
                                        <div class="fixedWidthFont">
                                            <a title="{{$rides->rideable->location->longName}}" href="/rideable/show/{{$rides->rideable->id}}">{{$rides->rideable->invoice_number}}</a>
                                            @if ($rides->rideable->status =='Returned')
                                                <span class="badge badge-pill badge-danger zindex-tooltip">Returned</span>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    {{$rides}}
                                @endif
                            @endforeach
                        </div>

                        <div class="card-footer row statistic font-70">
                            <small class=" col-12 text-muted pm-0">
                                Trip Counter : from total of
                                {{ $totalTrip = App\Ride::where('driver_id', $driver->id)->count() }}
                            </small>
                            <div class="col-3 pm-0">
                                <div>{{ App\Ride::where([
                                    ['driver_id', $driver->id],
                                    ["delivery_date","=",$dates['today']]
                                    ])->count() }}</div>
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
                                <div>{{ round($totalTrip/App\Ride::distinct()->select('delivery_date')->where('driver_id', 9)->count(),1) }} /day</div>

                                <div>Average</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
