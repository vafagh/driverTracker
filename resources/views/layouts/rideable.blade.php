<ul class="deliveries list-group" id='deliveries'>
    <li class="row m-0 py-1 bg-primary text-white rounded-top">
        <div class=" col-10">
            <h3 class="m-0 p-0">{{$op2}}</h3>
        </div>
        <div class="col-2">
            @component('layouts.components.modal',[
                'modelName'=>'rideable',
                'action'=>'create',
                'iterator'=>0,
                'object'=>null,
                'op1'=>$op1,
                'op2'=>$op2
            ])
            @endcomponent
        </div>
    </li>
    <li class="{{$op2}} list-group-item py-0 list-group-item-secondary">
        <div class="row m-0 p-0">
            <div class="col-6 row m-0">
                <div class=' col-5'>location</div>
                <div class=' col-3'>{{($op1=='Client') ? 'Part': 'Invoice'}}#</div>
                <div class=' col-4'>status</div>
            </div>
            <div class="col-6 row m-0">
                <div class=' col-4'>Driver/Truck</div>
                <div class=" col-4">Order</div>
                <div class=" col-4">Assigned</div>
            </div>
        </div>
    </li>
    @foreach ($collection as $key => $rideable)
        <li class="list-group-item row m-0 p-0">
            <div class="row m-0 p-0 {{($rideable->status=='NON.A')?'bg-danger text-light':'' }}">
                <div class="col-6 row m-0">
                    <div class='locationName col-5'>
                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$rideable->location])@endcomponent
                        <br>
                        <div class="text-secondary">
                            by <strong>{{$rideable->user->name}}</strong>
                            {{-- @component('layouts.components.tooltip',['modelName'=>'user','model'=>$rideable->user])@endcomponent --}}
                        </div>
                    </div>
                    <div class='InvoiceNumber col-3'>
                     @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])@endcomponent
                    </div>
                    <div class='Status col-4'>
                        {{$rideable->status}}<br>
                        @component('layouts.action',[
                            'action' => $rideable->status,
                            'rideable' => $rideable,
                            'iterator' => $key,
                            'op1'=>$op1,
                            'op2'=>$op2
                            ])
                        @endcomponent
                    </div>
                </div>
                <div class="col-6 row m-0">
                    @foreach ($rideable->rides as $ride)
                        <div class='driver col-6' style="background-image: url(/img/driver/{{$ride->driver->image}}); background-position: right bottom, left top; background-size:44px 44px; background-repeat: no-repeat, repeat;">
                            <div>
                                @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])@endcomponent
                            </div>
                            <a class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$rideable->id}}">x</a>
                            @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])@endcomponent
                        </div>
                        <div class="orderCreated col-3"><span title="{{$rideable->created_at}}">{{ $rideable->created_at->diffForHumans()}}</span></div>
                        <div class="truckCreated col-3"><span title="{{$ride->pivot->created_at}}">{{ $ride->pivot->created_at->diffForHumans()}}</span></div>
                    @endforeach

                </div>
            </div>
        </li>
    @endforeach
</ul>
