@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-light">
            <div class="col-11 h3">Services</div>
            <div class="col-1 p-0 m-0">
                @component('layouts.components.modal',[
                    'modelName'=>'service',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'service',
                    'dingbats'=>'<i class="material-icons">add_box</i>',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
            </div>
        </div>

        <div class="card-body">
            <div class='row font-weight-light h6'>
                <div class="{{$tr='col-4 col-sm-4 col-md-3 col-lg-3 col-xl-2'}}">Truck<br>Driver</div>
                <div class="{{$ser='col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2'}}">Service/<br>Description</div>
                <div class="{{$shop='col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2'}}">Shop/ <br>Mileage</div>
                <div class="{{$tot='col-4 col-sm-3 col-md-1 col-lg-1 col-xl-2'}} text-truncate"><strong>Total</strong><br>Voucher</div>
                <div class="{{$on='col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2'}}">On</div>
                <div class="{{$ac='col-4 col-sm-5 col-md-2 col-lg-2 col-xl-2'}}">Actions</div>
            </div>
            @foreach ($services as $key => $service)
                <div class="row py-2 mb-1 border">
                    <div class="{{$tr}}">
                        <div class="text-truncate">
                            @if ($service->truck!='') @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$service->truck]) @endcomponent @else{{$service->truck}} @endif
                        </div>
                    <div class="text-truncate">@if ($service->driver!=null) @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$service->driver]) @endcomponent</div> @else{{$service->driver}}@endif</div>
                    <div class="{{$ser}} text-truncate">
                        @if ($service->image!='')@component('layouts.components.imgtooltip',['modelName'=>'service','model'=>$service]) @endcomponent @endif
                            <strong>{{$service->product}}: </strong><span title="{{$service->description}}">{{$service->description}}</span></div>
                    <div class="{{$shop}}">{{$service->shop}}<br>{{$service->mileage}}</div>
                    <div class="{{$tot}}">
                        <span class="text-muted">$</span><span class='font-weight-bold'>{{$service->total}}</span><br>
                        <span class="text-muted">#</span>{{$service->voucher_number}}
                    </div>
                    @if ($service->created_at!='')

                        <div class="{{$on}}" title="{{$service->created_at->diffForHumans()}}">
                            {{$service->created_at->toFormattedDateString()}}<br>
                            <span class="text-muted font-weight-light">{{$service->created_at->toTimeString()}}</span>
                        </div>
                    @else
                        <div class="{{$on}}">
                            <span class="text-muted font-weight-light">Not set</span>
                        </div>
                    @endif
                    <div class="{{$ac}}">
                        <a href="/service/show/{{$service->id}}"><i class="material-icons">pageview</i></a>
                            @if (Auth::user()->role_id > 3)
                            @component('layouts.components.modal',[
                                'modelName'=>'service',
                                'action'=>'edit',
                                'iterator'=>$key,
                                'object'=>$service,
                                'btnSize'=>'small',
                                'style'=>'badge badge-info',
                                'dingbats'=>'<i class="material-icons">edit</i>',
                                'op1'=>'',
                                'op2'=>'',
                                'file'=>true
                            ])@endcomponent
                            <a title='Delete' class="badge badge-danger p-0" href="/service/delete/{{$service->id}}"><i class="material-icons">delete_forever</i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
