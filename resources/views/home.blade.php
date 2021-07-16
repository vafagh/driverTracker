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


<div class="drivers card my-2">
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
