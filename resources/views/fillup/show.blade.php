@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-light">
            <div class="col-10 h3 mb-0">Fillup details</div>
            <div class="col-2">
                @component('layouts.components.modal',[
                    'modelName'=>'fillup',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'fillup',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
            </div>
        </div>

        <div class="card-body row p-0 m-0">
            <div class="row col-4 p-0 m-0">
                <div class="col-9">
                    @if (isset($fillup->image))
                        <img class="w-100" src="/img/fillup/{{$fillup->image}}">
                    @else
                        <div class="p-4 text-muted text-center">
                            Receipt image not uploaded!
                        </div>
                    @endif
                </div>
                <div class="col-3 ">
                    <img class="w-100" src="/img/driver/{{$fillup->driver->image}}">
                    <img class="w-100" src="/img/truck/{{$fillup->truck->image}}">
                </div>
            </div>
            <div class="col-8">
                <table class="table table-fluid">
                    <tbody>
                        <tr>
                            <th>Truck</th>
                            <td> @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$fillup->truck])@endcomponent
                            </td>
                        </tr>

                        <tr>
                            <th>Driver</th>
                            <td>@component('layouts.components.tooltip',['modelName'=>'driver','model'=>$fillup->driver])@endcomponent</td>
                        </tr>

                        <tr>
                            <th>Gas Card</th>
                            <td>{{$fillup->gas_card}}</td>
                        </tr>

                        <tr>
                            <th>Gallons</th>
                            <td>{{$fillup->gallons}}</td>
                        </tr>

                        <tr>
                            <th>Product</th>
                            <td>{{$fillup->product}}</td>
                        </tr>

                        <tr>
                            <th>Price Per Gallons</th>
                            <td>{{$fillup->price_per_gallon}}</td>
                        </tr>

                        <tr>
                            <th>Total</th>
                            <td>{{$fillup->total}}</td>
                        </tr>

                        <tr>
                            <th>Mileage</th>
                            <td>{{$fillup->mileage}}</td>
                        </tr>

                        <tr>
                            <th>On</th>
                            <td><span title="{{$fillup->created_at}}">{{$fillup->created_at->diffForHumans()}}</span></td>
                        </tr>

                        <tr>
                            <td>
                                @if (Auth::user()->role_id > 3)
                                    @component('layouts.components.modal',[
                                        'modelName'=>'fillup',
                                        'action'=>'edit',
                                        'iterator'=>'',
                                        'object'=>$fillup,
                                        'btnSize'=>'small',
                                        'op1'=>'',
                                        'op2'=>'',
                                        'file'=>true
                                    ])
                                    <tr><th>ID</th>
                                    @endcomponent
                                    <a class="badge badge-danger" href="/fillup/delete/{{$fillup->id}}"> Delete</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
        </div>
    </div>
@endsection
