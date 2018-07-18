@extends('layouts.app')
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header row m-0">
                <div class="col-10">
                    Drivers
                </div>
                <div class="col-2">
                    @component('layouts.components.modal',[
                        'modelName'=>'driver',
                        'action'=>'create',
                        'object'=>null,
                        'op1'=>'op1',
                        'op2'=>'driver',
                        'iterator'=>0,
                        'file'=>true
                    ])
                    @endcomponent
                </div>

            </div>
            <div class="card-body">
                <ul class="list-group" id='driverd'>
                    <li class="driver list-group-item py-0 list-group-item-secondary">
                        <div class="row m-0 p-0">
                            <div class='col-4 text-center'>
                                Info
                            </div>
                            <div class="col-4">Created at</div>
                            <div class='col-2'>Miles Driven</div>
                            <div class='col-2'>Total Trip</div>
                        </div>
                    </li>
                        <li class="list-group-item disabled py-2 active font-weight-bold">{{$driver->fname.' '.$driver->lname}}</li>
                        <li class="row m-0 p-0 mb-1 border  border-secondary">
                            <div class="col-2 bg-danger p-0">
                                <img class="w-100" src="{{($driver->image == null) ? '/img/def.svg' : '/img/avatars/'.$driver->image }}" alt="">
                            </div>
                            <div class="col-10">
                                <div class="row mx-0  pt-2">
                                    <div class="col-3">
                                        {{$driver->fname.' '.$driver->lname}}
                                    </div>
                                    <div  class="col-5">
                                        {{$driver->created_at}}
                                    </div>
                                    <div  class="col-2">
                                        <h2 class="mb-0">{{App\Ride::where('driver_id', $driver->id)->sum('distance')}} </h2>Mile
                                    </div>
                                    <div  class="col-2">
                                        <h2 class="mb-0">{{ App\Ride::where('driver_id', $driver->id)->count() }} </h2>Trip
                                    </div>
                                </div>
                                <div class="row m-0  pb-2">
                                    <div class="col-5 ">
                                        {{$driver->phone}}
                                    </div>
                                    <div class="col-7 text-right  pt-2">
                                            @component('layouts.components.modal',[
                                                'modelName'=>'driver',
                                                'action'=>'edit',
                                                'op1'=>'op1',
                                                'op2'=>'driver',
                                                'btnSize'=>'small',
                                                'object'=>$driver,
                                                'iterator'=>'',
                                                'file'=>true
                                            ])
                                            @endcomponent
                                    </div>
                                </div>
                            </div>

                        </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header row m-0">
                    All Rides
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>For</th>
                                <th>Destination</th>
                                <th>Truck</th>
                                <th>Create</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($driver->rides as $key => $ride)
                                <tr>
                                    <td>{{$ride->id}}</td>
                                    <td>
                                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])@endcomponent
                                    </td>
                                    <td>
                                        {{$ride->rideable->status}}
                                    </td>
                                    <td>
                                        @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])@endcomponent
                                    </td>
                                    <td><span title="{{$ride->created_at}}">{{$ride->created_at->diffForHumans()}}</span></td>
                                    <td>
                                        @component('layouts.components.modal',[
                                            'modelName'=>'ride',
                                            'action'=>'edit',
                                            'iterator'=>$key,
                                            'object'=>$ride,
                                            'btnSize'=>'small',
                                            'op1'=>'',
                                            'op2'=>''
                                        ])
                                        @endcomponent
                                        <a class="badge badge-danger" href="/ride/delete/{{$ride->id}}"> Delete</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header row m-0">
                    Fillups
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Truck</th>
                                <th>Gas Card</th>
                                <th>Gallons</th>
                                <th>Product</th>
                                <th>PPG</th>
                                <th>Total</th>
                                <th>Mileage</th>
                                <th>On</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($driver->fillups as $key => $fillup)
                                <tr>
                                    <td>{{$fillup->id}}</td>
                                    <td>@component('layouts.components.tooltip',['modelName'=>'truck','model'=>$fillup->truck])@endcomponent</td>
                                    <td>{{$fillup->gas_card}}</td>
                                    <td>{{$fillup->gallons}}</td>
                                    <td>{{$fillup->product}}</td>
                                    <td>{{$fillup->price_per_gallon}}</td>
                                    <td>{{$fillup->total}}</td>
                                    <td>{{$fillup->mileage}}</td>
                                    <td><span title="{{$fillup->created_at}}">{{$fillup->created_at->diffForHumans()}}</span></td>
                                    <td>
                                        @component('layouts.components.modal',[
                                            'modelName'=>'fillup',
                                            'action'=>'edit',
                                            'iterator'=>$key,
                                            'object'=>$fillup,
                                            'btnSize'=>'small',
                                            'op1'=>'',
                                            'op2'=>'',
                                            'file'=>true
                                        ])
                                        @endcomponent
                                        <a class="badge badge-danger" href="/fillup/delete/{{$fillup->id}}"> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
