@if ($defaultPickups && $defaultPickups->count()>0)
    <div class="card-header">
        <span>
            <i class="material-icons md-1">business</i>
            Assigned to pickup from:
        </span>
        @foreach ($defaultPickups as $location)
            @component('layouts.components.tooltip',['modelName'=>'location','model'=>$location])
            @endcomponent,
        @endforeach
    </div>
@endif

<div class="card-header  m-0 justify-around">
    @if ($unassignLocations && $driver->truck_id != null)

        <i class="material-icons md-1">store_mall_directory</i>
        <span class="btn btn-sm ml-4">Un-assigned deliveries:</span>

        @foreach ($unassignLocations as $location)
            <div class="add d-inline btn btn-secondary mr-1">
                {{$location->name}}
                <a class="badge badge-info{{(Auth::user()->role_id>3 && $location->type=='DropOff') ?' d-none':''}} badge-sm  h-75" title="{{$location->name}}" href="/location/{{$location->id}}/{{$driver->id}}/{{$today}}/Morning">
                    <i class="material-icons md-14 text-dark">add</i>
                </a>
                <a class="badge badge-warning{{(Auth::user()->role_id>3 && $location->type=='DropOff') ?' d-none':''}} badge-sm text-white h-75" title="{{$location->name}}" href="/location/{{$location->id}}/{{$driver->id}}/{{$today}}/Evening">
                    <i class="material-icons md-14 text-dark">add</i>
                </a>
            </div>
        @endforeach

        @if (empty($date))
            <div class="add d-inline"><a class="btn btn-danger{{(Auth::user()->role_id==3) ?' d-none':''}} btn-sm text-white h-75" title="See other days" href="?date=all"><i class="material-icons md-14 text-dark">calendar_today</i>More</a></div>
        @else
            <div class="add d-inline"><a class="btn btn-danger{{(Auth::user()->role_id==3) ?' d-none':''}} btn-sm text-white h-75" title="Only Today's" href="?date="><i class="material-icons md-14 text-dark">today</i>Less</a></div>
        @endif
    @else
        <div class="">
            There is not any unassign ticket to display!
            <div class="add d-inline"><a class="btn btn-danger{{(Auth::user()->role_id==3) ?' d-none':''}} btn-sm text-white h-75" title="See other days" href="?date=all"><i class="material-icons md-14 text-dark">calendar_today</i>Other day</a></div>
        </div>

    @endif
    @component('layouts.components.modal',['modelName'=>'rideable','action'=>'create','iterator'=>0,'object'=>null,'op1'=>'Client','op2'=>'Delivery','style'=>'bg-light','dingbats'=>'<i class="material-icons">add_box</i>','autocomplateOff'=>true])
    @endcomponent
</div>
