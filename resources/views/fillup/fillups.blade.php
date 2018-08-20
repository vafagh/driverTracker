@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-white">
            <div class="col-10 h3">Fillups</div>
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

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Recipt</th>
                        <th>Truck</th>
                        <th>Driver</th>
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
                    @foreach ($fillups as $key => $fillup)

                        <tr>
                            <td><a href="/fillup/show/{{$fillup->id}}">{{$fillup->id}}</a></td>
                            <td>
                                @if ($fillup->image!='')
                                    @component('layouts.components.imgtooltip',['modelName'=>'fillup','model'=>$fillup])@endcomponent
                                @endif
                            </td>
                            <td>
                                @if ($fillup->truck!='')
                                    @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$fillup->truck])@endcomponent</td>
                                @else
                                    {{$fillup->truck}}
                                @endif
                            <td>
                                @if ($fillup->driver)
                                    @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$fillup->driver])@endcomponent</td>
                                @else
                                    {{$fillup->driver}}
                                @endif
                            <td>{{$fillup->gas_card}}</td>
                            <td>{{$fillup->gallons}}</td>
                            <td>{{$fillup->product}}</td>
                            <td>{{$fillup->price_per_gallon}}</td>
                            <td>{{$fillup->total}}</td>
                            <td>{{$fillup->mileage}}</td>
                            <td><span title="{{$fillup->created_at}}">{{$fillup->created_at->diffForHumans()}}</span></td>
                            <td>
                                @if (Auth::user()->role_id > 3)
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
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
