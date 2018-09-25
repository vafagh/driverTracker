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
                            <th>Assigned on</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="pagination">
                                    {{ $rides->links("pagination::bootstrap-4") }}
                                </div>
                            </td>
                        </tr>
                        @foreach ($truck->rides->sortByDesc('created_at') as $key => $ride)
                            <tr>
                                <td>{{$ride->id}}</td>
                                @if (!empty($ride->rideable))
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
                                <td>
                                    <div title="{{$ride->created_at->diffForHumans()}}">
                                        {{$ride->created_at->toFormattedDateString()}}
                                        <span class="text-muted font-weight-light">{{$ride->created_at->toTimeString()}}</span>
                                    </div>
                                </td>
                                <td>
                                    @if (Auth::user()->role_id > 3)
                                        @component('layouts.components.modal',[
                                            'modelName'=>'ride',
                                            'action'=>'edit',
                                            'iterator'=>$key,
                                            'object'=>$ride,
                                            'btnSize'=>'small',
                                            'op1'=>'',
                                            'op2'=>''])
                                        @endcomponent
                                        <a class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$ride->rideable->id}}"> Detach</a>
                                    @endif
                                </td>
                            @else
                                <td colspan="6">
                                    The ticket is deleted.
                                    @if (Auth::user()->role_id>3)
                                        <a href="/ride/delete/{{$ride->id}}">remove this line</a>
                                    @endif
                                </td>
                            @endif
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                <div class="pagination">
                                    {{ $rides->links("pagination::bootstrap-4") }}
                                </div>
                            </td>
                        </tr>
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
                        @foreach ($truck->fillups as $key => $fillup)
                            <tr>
                                <td>{{$fillup->id}}</td>
                                <td>@component('layouts.components.tooltip',['modelName'=>'driver','model'=>$fillup->driver])@endcomponent</td>
                                <td>{{$fillup->gas_card}}</td>
                                <td>{{$fillup->gallons}}</td>
                                <td>{{$fillup->product}}</td>
                                <td>${{$fillup->price_per_gallon}}</td>
                                <td>${{$fillup->total}}</td>
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
