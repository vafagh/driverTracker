<ul class="deliveries list-group p-0" id='deliveries'>
    <li class="d-flex justify-content-between m-0 py-1 bg-primary text-white rounded-top">
        <div sclass="col-6 col-md-9 col-lg-6">
            <h3 class="m-0 p-0 pl-2">{{$op2}}</h3>
        </div>

        <div sclass="col-6 col-md-3 col-lg-4">
<span class="badge">sort by: </span>
            <a class="badge badge-primary   " href="?sortby=invoice_number">#</a>
            <a class="badge badge-primary   " href="?sortby=location_id">Location</a>
            <a class="badge badge-primary   " href="?sortby=created_at">Date</a>
            <a class="badge badge-primary   " href="?sortby=updated_at">Update</a>
            <a class="badge badge-primary   " href="?sortby=status">Status</a>
            <a class="badge badge-primary   " href="?sortby=user_id">User</a>
            @component('layouts.components.modal',[
                'modelName'=>'rideable',
                'action'=>'create',
                'iterator'=>0,
                'object'=>null,
                'op1'=>$op1,
                'op2'=>$op2,
                'autocomplateOff'=>true
            ])@endcomponent
        </div>
    </li>

    <div class="pagination">
        {{ $collection->links("pagination::bootstrap-4") }}
    </div>

    <li class="{{$op2}} list-group-item p-0 list-group-item-secondary">
        <div class="row m-0 p-0">
            <div class="col-12 col-md-9 row m-0 p-0">
                <div class=' pr-0 col-4'>location</div>
                <div class=' pr-0 col-4'>{{($op1=='Client') ? 'Invoice': 'Part'}}#</div>
                <div class=' pr-0 col-4'>Status</div>
            </div>
            <div class="col-12 col-md-3 row m-0 p-0  d-none d-sm-flex">Driver/Truck</div>
        </div>
    </li>

    @foreach ($collection as $key => $rideable)
        <li class="list-group-item row m-0 p-0 {{$rideable->status}}" id="rideable{{$rideable->id}}">
            <div class="row m-0 p-0 py-2" {{($flashId==$rideable->id)? 'id="flash"':''}}>
                <div class="col-12 col-lg-9 col-md-8 row m-0 p-0">

                    <div class='location            col-6 col-md-4'>
                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$rideable->location])@endcomponent
                    </div>

                    <div class='InvoiceNumber       col-12 col-md-4 fixedWidthFont'>
                        @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                            @component('layouts.components.modal',[
                                'modelName'=>'rideable',
                                'action'=>'edit',
                                'dingbats'=>'<i class="material-icons md-16">border_color</i>',
                                'style'=>'badge badge-warning mr-1 float-left',
                                'iterator'=>$key,
                                'object'=>$rideable,
                                'op1'=>$rideable->type,
                                'op2'=>'',
                                'file'=>false,
                                'autocomplateOff'=>true])
                            @endcomponent
                        @endif
                        @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])@endcomponent
                    </div>

                    <div class='status              col-6 col-md-4'>
                        <strong>{{$rideable->status}}</strong>
                    </div>

                    <div class="user text-secondary col-12 col-lg-4 col-md-5">
                        @if (Auth::user()->role_id > 4)
                            @component('layouts.components.tooltip',['modelName'=>'user','model'=>$rideable->user])@endcomponent
                            @else
                            by <strong>{{$rideable->user->name}}</strong>
                        @endif
                        <span title="{{$rideable->created_at}}">{{ $rideable->created_at->diffForHumans()}}</span>
                    </div>

                    <div class="actions             col-12 col-lg-4 col-md-3">
                        @component('layouts.action',[
                            'action' => $rideable->status,
                            'rideable' => $rideable,
                            'iterator' => $key,
                            'op1'=>$op1,
                            'op2'=>$op2
                        ])@endcomponent
                    </div>

                    <div class='updated             col-12 col-lg-4 col-md-3'>
                        <span title="{{$rideable->updated_at}}">{{ $rideable->updated_at->diffForHumans()}}</span>
                    </div>

                </div>
                <div class="col-12 col-lg-3 col-md-4 row m-0 p-0">
                    @foreach ($rideable->rides as $ride)
                        <div class='driver col-12 border-bottom border-secondary pb-0' style="background-image: url(/img/driver/{{$ride->driver->image}}); background-position: right top, left top; background-size:44px; background-repeat: no-repeat, repeat;">
                            <div>
                                <span class="d-md-none text-muted">D/T: </span>
                                @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])@endcomponent
                                <span title="{{$ride->pivot->created_at}}">{{ $ride->pivot->created_at->diffForHumans()}}</span>
                            </div>
                            @if (Auth::user()->role_id > 2  && $loop->last)
                                <a class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$rideable->id}}">
                                    <i class="material-icons md-16">remove_circle_outline</i>
                                </a>
                            @endif
                            @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])@endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </li>
    @endforeach
    <div class="pagination">
        {{ $collection->links("pagination::bootstrap-4") }}
    </div>
</ul>
