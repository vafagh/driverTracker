@extends('layouts.app')

@section('content')

    <div class="locations card">
        <div class="card-header">Today's Pickups by locations</div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($warehouses as $key => $warehouse)
                    @php
                        $rideable = $warehouse->rideables->whereIn('status',['OnTheWay','Created','NotAvailable','Returned','DriverDetached','DeatachReqested']);
                    @endphp
                    @if ($rideable->count()>0)
                        <div class="card col-6 col-sm-4 col-md-3 col-lg-2 px-0">
                            <div class="card-header text-center mh-20 px-0 py-1 ">
                                @component('layouts.components.tooltip',
                                ['modelName'=>'location','model'=>$warehouse])@endcomponent
                            </div>

                            <div class="card-body px-1">
                                <p class="card-text">
                                    <small class="text-muted">
                                        Total trip :{{ App\Rideable::where('location_id', $warehouse->id)->count() }}
                                    </small>
                                    {{-- @foreach (App\Rideable::where([['status','!=','Done'],['status','!=','Canceled'],['status','!=','Delete'],['location_id',$warehouse->id]])->get() as $key => $value) --}}
                                     @foreach ($rideable as $key => $value)
                                        <div class="fixedWidthFont">
                                            {{$value->invoice_number}}
                                        </div>

                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="drivers card">
        <div class="card-header">Today's ride by driver</div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($activeDrivers as $key => $driver)
                    @php
                    $totalRides = App\Ride::where('driver_id',$driver->id)
                                ->whereDate('created_at', '=', Carbon\Carbon::today())
                                ->get();
                    @endphp

                    <div class="card col-6 col-sm-4 col-md-3 col-lg-2 px-0 {{$totalRides->count() > 0 ? '' : 'd-none' }}">
                        <div class="card-header text-center mh-20 px-0 py-1 ">
                            @component('layouts.components.tooltip',
                            ['modelName'=>'driver','model'=>$driver])@endcomponent
                        </div>

                        <div class="card-body px-1">
                            <p class="card-text">
                                <small class="text-muted">
                                    Total trip :{{ App\Ride::where('driver_id', $driver->id)->count() }}
                                </small>
                                @foreach ($totalRides as $key => $rides)
                                                @if (isset($rides->rideable))
                                                    @if ($rides->rideable->status !='Done')
                                                        <div class="fixedWidthFont">
                                                            <a title="{{$rides->rideable->location->longName}}" href="/rideable/show/{{$rides->rideable->id}}">{{$rides->rideable->invoice_number}}</a>
                                                            @if ($rides->rideable->status =='Returned')
                                                                <i class="material-icons size-14">keyboard_return</i>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @else
                                                {{$rides}}
                                                @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
