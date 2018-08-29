@extends('layouts.app')
@section('content')
        <div class="card">
            <div class="card-header row m-0">
                <div class="col-10">
                    Trucks
                </div>
                <div class="col-2">
                    @component('layouts.components.modal',[
                        'modelName'=>'truck',
                        'action'=>'create',
                        'object'=>null,
                        'op1'=>'op1',
                        'op2'=>'truck',
                        'iterator'=>0,
                        'file'=>true
                    ])
                    @endcomponent
                </div>

            </div>
            <div class="card-body">
                @component('truck.oneTruck',['truck'=> $truck,'key'=>''])
                    File Missing!
                @endcomponent
            </div>
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
                            <th>{{--($op1=='Client') ? 'Invoice': 'Part'--}}#</th>
                            <th>Destination</th>
                            <th>Driver</th>
                            <th>Create</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($truck->rides as $key => $ride)
                            <tr>
                                <td>{{$ride->id}}</td>
                                <td>
                                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])@endcomponent
                                </td>
                                <td>
                                    @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$ride->rideable])@endcomponent
                                </td>
                                <td>
                                    {{$ride->rideable->status}}
                                </td>
                                <td>
                                    @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])@endcomponent
                                </td>
                                <td><span title="{{$ride->created_at}}">{{$ride->created_at->diffForHumans()}}</span></td>
                                <td>
                                    @if (Auth::user()->role_id > 3)
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
                                    @endif
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
                        @foreach ($truck->fillups as $key => $fillup)
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
@endsection
