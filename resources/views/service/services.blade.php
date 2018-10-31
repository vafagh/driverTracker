@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-white">
            <div class="col-10 h3">Services</div>
            <div class="col-2">
                @component('layouts.components.modal',[
                    'modelName'=>'service',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'service',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invoice</th>
                        <th>Truck</th>
                        <th>Driver</th>
                        <th>Service</th>
                        <th>Description</th>
                        <th>Shop</th>
                        <th>Mileage</th>
                        <th>Total</th>
                        <th>Voucher</th>
                        <th>On</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $key => $service)
                        <tr>
                            <td><a href="/service/show/{{$service->id}}">{{$service->id}}</a></td>
                            <td>
                                @if ($service->image!='')
                                    @component('layouts.components.imgtooltip',['modelName'=>'service','model'=>$service])@endcomponent
                                @endif
                            </td>
                            <td>
                                @if ($service->truck!='')
                                    @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$service->truck])@endcomponent</td>
                                @else
                                    {{$service->truck}}
                                @endif
                            <td>
                                @if ($service->driver)
                                    @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$service->driver])@endcomponent</td>
                                @else
                                    {{$service->driver}}
                                @endif
                            <td>{{$service->product}}</td>
                            <td>{{$service->description}}</td>
                            <td>{{$service->shop}}</td>
                            <td>{{$service->mileage}}</td>
                            <td><span class="text-muted">$</span>{{$service->total}}</td>
                            <td><span class="text-muted">#</span>{{$service->voucher_number}}</td>
                            <td>
                                <div title="{{$service->created_at->diffForHumans()}}">
                                    {{$service->created_at->toFormattedDateString()}}
                                    <span class="text-muted font-weight-light">{{$service->created_at->toTimeString()}}</span>
                                </div>
                            </td>
                            <td>
                                @if (Auth::user()->role_id > 3)
                                    @component('layouts.components.modal',[
                                        'modelName'=>'service',
                                        'action'=>'edit',
                                        'iterator'=>$key,
                                        'object'=>$service,
                                        'btnSize'=>'small',
                                        'style'=>'badge badge-info',
                                        'op1'=>'',
                                        'op2'=>'',
                                        'file'=>true
                                    ])
                                    @endcomponent
                                    <a class="badge badge-danger" href="/service/delete/{{$service->id}}"> Delete</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
