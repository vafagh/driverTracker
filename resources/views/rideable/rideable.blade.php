<ul class="deliveries list-group p-0" id='deliveries'>
    <li class="row m-0 py-1 bg-primary text-white rounded-top">
        <div class="col-6 col-md-9 col-lg-10">
            <h3 class="m-0 p-0">{{$op2}}</h3>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            @component('layouts.components.modal',[
                'modelName'=>'rideable',
                'action'=>'create',
                'iterator'=>0,
                'object'=>null,
                'op1'=>$op1,
                'op2'=>$op2
            ])@endcomponent
        </div>
    </li>
    <li class="{{$op2}} list-group-item p-0 list-group-item-secondary">
        <div class="row m-0 p-0">
            <div class="col-12 col-md-5 row m-0 p-0">
                <div class=' pr-0 col-3'>location</div>
                <div class=' pr-0 col-3'>{{($op1=='Client') ? 'Invoice': 'Part'}}#</div>
                <div class=' pr-0 col-6'>Status</div>
            </div>
            <div class="col-12 col-md-7 row m-0 p-0  d-none d-sm-flex">
                <div class="pr-0 col-3">Order</div>
                <div class="pr-0 col-6">Driver/Truck</div>
                <div class="pr-0 col-3">Assigned</div>
            </div>
        </div>
    </li>
    @foreach ($collection as $key => $rideable)
        <li class="list-group-item row m-0 px-0 py-2  {{$rideable->status}}" id="rideable{{$rideable->id}}">
            <div class="row m-0 p-0">
                <div class="col-12 col-md-5 row m-0 p-0">
                    <div class='location_user       col-5 col-sm-5 col-md-5'>
                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$rideable->location])@endcomponent
                        <div class="user text-secondary">
                            by <strong>{{$rideable->user->name}}</strong>
                            {{-- @component('layouts.components.tooltip',['modelName'=>'user','model'=>$rideable->user])@endcomponent --}}
                        </div>
                    </div>
                    <div class="part_status_actions col-7 col-sm-7 col-md-7 row m-0 p-0">
                        <div class='InvoiceNumber col-12 col-md-6'>@component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])@endcomponent</div>
                        <div class='Status col-12 col-md-6'><strong>{{$rideable->status}}</strong></div>
                        <div class="">@component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'iterator' => $key,'op1'=>$op1,'op2'=>$op2])@endcomponent</div>
                    </div>
                </div>
                <div class="col-12 col-md-7 row m-0">
                    @foreach ($rideable->rides as $ride)
                        <div class="orderCreated col-12 col-md-3 ">
                            <span class="d-md-none text-muted">Order: </span>
                            <span title="{{$rideable->created_at}}">{{ $rideable->created_at->diffForHumans()}}</span>
                        </div>
                        <div class='driver col-12 col-md-6' style="background-image: url(/img/driver/{{$ride->driver->image}}); background-position: right bottom, left top; background-size:44px 44px; background-repeat: no-repeat, repeat;">
                        <div class="">
                            <span class="d-md-none text-muted">D/T: </span>
                            @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])@endcomponent
                        </div>
                            <a class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$rideable->id}}">x</a>
                            @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])@endcomponent
                        </div>
                        <div class="truckCreated col-12 col-md-3">
                            <span class="d-md-none text-muted">Assigned: </span>
                            <span title="{{$ride->pivot->created_at}}">{{ $ride->pivot->created_at->diffForHumans()}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </li>
    @endforeach
</ul>
