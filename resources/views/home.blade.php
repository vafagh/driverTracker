@extends('layouts.app')

@section('content')

    <div class="pickups card">
        <div class="card-header bg-primary text-light d-flex justify-content-between">
            <div class="">
                <a class="text-light" title="Today" href="/"><i class="material-icons">today</i></a>
                <span>Pickups by locations on: </span>
                <a class="text-light" title="Go one Months backward" href="/?history={{$dt->copy()->submonths(1)->format('Y-m-d')}}"><i class="material-icons">fast_rewind</i></a>
                <a class="text-light" title="Go one Weeks backward" href="/?history={{$dt->copy()->subWeeks(1)->format('Y-m-d')}}"><i class="material-icons">skip_previous</i></a>
                <a class="text-light" title="Go one Days backward" href="/?history={{$dt->copy()->subDays(1)->format('Y-m-d')}}"><i class="material-icons">keyboard_arrow_left</i></a>
                <span>{{$dt->toFormattedDateString()}}</span>
                <a class="text-light" title="Go one Days forward" href="/?history={{$dt->copy()->addDays(1)->format('Y-m-d')}}"><i class="material-icons">keyboard_arrow_right</i></a>
                <a class="text-light" title="Go one Weeks forward" href="/?history={{$dt->copy()->addWeeks(1)->format('Y-m-d')}}"><i class="material-icons">skip_next</i></a>
                <a class="text-light" title="Go one Months forward" href="/?history={{$dt->copy()->addmonths(1)->format('Y-m-d')}}"><i class="material-icons">fast_forward</i></a>
            </div>
            <div class="create">
                @component('layouts.components.modal',['modelName'=>'rideable','action'=>'create','iterator'=>0,'object'=>null,'op1'=>'Warehouse','op2'=>'Pickup','style' => '','dingbats'=>'<i class="material-icons">add_box</i>','autocomplateOff'=>true])
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

                        <div class="card-body p-0">
                            @foreach ($warehouse->rideables->whereIn('status',['Created','OnTheWay','NotAvailable','DriverDetached']) as $key => $rideable)
                                <div class="row {{$rideable->status}} m-0 p-0 text-uppercase border-bottom mb-1">
                                    <div class="InvoiceNumber col-7 line text-truncate px-0">
                                        <div class="font-70">
                                            @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                                                <div class="d-inline pl-1">
                                                    @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','object'=>$rideable,'iterator'=>$key,'op1'=>$rideable->type,'op2'=>'','dingbats'=>'<i class="material-icons md-16">edit</i>','style'=>'text-info pr-0','file'=>false,'autocomplateOff'=>true])
                                                    @endcomponent
                                                </div>
                                            @endif
                                            <div class="InvoiceNumber fixedWidthFont d-inline"  title="{{$rideable->created_at}}">
                                                @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action col-5 line p-0 text-right pr-2">
                                        <div class="showOnHover">
                                                @component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'iterator' => $rideable->id,'op1'=>'Warehouse','op2'=>'Pickup'])
                                                @endcomponent
                                        </div>
                                        <div class="hideOnHover">
                                            <div class="mt-1">
                                                {{($rideable->user->name)}}
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
                @foreach ($activeDrivers as $key => $driver)
                    @php
                        $totalRides = App\Ride::where('driver_id',$driver->id)->whereDate('created_at', '=', $history)->get();
                    @endphp

                    <div class="card col-6 col-sm-4 col-md-3 col-lg-2 px-0 {{$totalRides->count() > 0 ? '' : 'd-none' }}">
                        <div class="card-header pt-1 pb-1 d-flex justify-content-between">
                            @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$driver])
                            @endcomponent
                            @if ($driver->fname != 'Pickup')
                                <a class='text-dark' href="/driver/{{$driver->id}}/today/direction" class='text-white' title='Direction'><i class="material-icons md-16">directions</i></a>
                            @endif
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

        {{-- <div class="card-footer ">
            <span>Total of {{$spots->count()}} unassigned ticket.</span>
            @foreach ($spots as $spot)
                <div class="line d-inline-block bg-secondary p-1 border">
                        {{$spot->name}}:
                    @foreach (App\Rideable::where('location_id',$spot->id)->whereDoesntHave('rides')->get() as $unassignedTicket)
                        <span class="btn btn-success btn-sm text-white h-75">
                            {{$unassignedTicket->invoice_number}}
                        </span>
                    @endforeach
                </div>
            @endforeach
        </div> --}}
    </div>
@endsection
