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
        <div class="card">
            <div class="card-header row m-0">
                Services
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
                @foreach ($truck->services as $key => $service)
                    <div class="row py-2 mb-1 border">
                        <div class="{{$tr}}">
                        <div class="text-truncate">@if ($service->driver) @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$service->driver]) @endcomponent</div> @else{{$service->driver}}@endif</div>
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
