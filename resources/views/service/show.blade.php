@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-light">
            <div class="col-10 h3 mb-0">Service details</div>
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

        <div class="card-body row p-0 m-0">
            <div class="row col-4 p-0 m-0">
                <div class="col-9">
                    @if (filled($service->image))
                        <a href="/img/service/{{$service->image}}">
                            <img class="w-100" src="/img/service/{{$service->image}}">
                        </a>
                    @else
                        <div class="p-4 text-muted text-center">
                            Receipt image not uploaded!
                        </div>
                    @endif
                </div>
                <div class="col-3 ">
                    @if (!empty($service->driver->image))
                    <img class="w-100" src="/img/driver/{{$service->driver->image}}">
                @endif
                @if (!empty($service->truck->image)){{$service->truck->image}}
                    <img class="w-100" src="/img/truck/{{$service->truck->image}}">
                @endif
                </div>
            </div>
            <div class="col-8">
                <table class="table table-fluid">
                    <tbody>
                        <tr>
                            <th>Truck</th>
                            <td> @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$service->truck])@endcomponent
                            </td>
                        </tr>

                        <tr>
                            <th>Driver</th>
                            <td>@component('layouts.components.tooltip',['modelName'=>'driver','model'=>$service->driver])@endcomponent</td>
                            </tr>

                            <tr>
                                <th>Product</th>
                                <td>{{$service->product}}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{$service->description}}</td>
                            </tr>
                            <tr>
                                <th>Mileage</th>
                                <td>{{$service->mileage}}</td>
                            </tr>

                            <tr>
                                <th>Shop name</th>
                                <td>{{$service->shop}}</td>
                            </tr>
                            <tr>
                                <th>Shop phone</th>
                                <td>{{$service->shop_phone}}</td>
                            </tr>
                            <tr>
                                <th>Eagle Voucher</th>
                                <td># {{$service->voucher_number}}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>$ {{$service->total}}</td>
                            </tr>


                            <tr>
                                <th>On</th>
                                <td><div title="{{$service->created_at->diffForHumans()}}">
                                    {{$service->created_at->toFormattedDateString()}}
                                    <span class="text-muted font-weight-light">{{$service->created_at->toTimeString()}}</span>
                                </div></td>
                            </tr>

                            <tr>
                                <td>
                                    @if (Auth::user()->role_id > 3)
                                        @component('layouts.components.modal',[
                                            'modelName'=>'service',
                                            'action'=>'edit',
                                            'iterator'=>'',
                                            'object'=>$service,
                                            'btnSize'=>'small',
                                            'op1'=>'',
                                            'op2'=>'',
                                            'file'=>true
                                        ])
                                        <tr><th>ID</th>
                                        @endcomponent
                                        <a class="badge badge-danger" href="/service/delete/{{$service->id}}"> Delete</a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
