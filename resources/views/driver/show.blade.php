@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-body p-0">
            <ul class="list-group" id='driverd'>
                <li class="row m-0 p-0">
                    <div class="image p-0   col-1 ">
                        <img class="minh-100 rounded" src="{{($driver->image == null) ? '/img/def.svg' : '/img/driver/'.$driver->image }}" alt="">
                    </div>
                    <div class="row p-0 m-0     col-11">
                        <div class="name        col-12  py-1 bg-primary text-light font-weight-bold h3 d-flex justify-content-around">
                            <div class="">
                                {{$driver->fname.' '.$driver->lname}}
                            </div>
                            <div class="">
                                @if (Auth::user()->role_id > 2)
                                    @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                    @endcomponent
                                @endif
                            </div>
                        </div>
                        <div class="phone       col-12 col-sm-7 col-md-5 col-lg-3 col-xl-3 ">
                            <div class="title">Phone</div>
                            <a class="h3 " href="tel:{{$driver->phone}}" title="Click to Call!">{{$driver->phone}}</a>
                        </div>
                        <div class="miles       col-6 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                            <span class="h2 mb-0">
                                {{$driver->totalDistance()}}
                            </span>Mile
                            <div class="title">Driven</div>
                        </div>
                        <div class="trip        col-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                            <span class="h2 mb-0">
                                {{ $driver->totalTrip() }}
                            </span>Trip
                        </div>
                        <div class="truck       col-12 col-sm-9 col-md-6 col-lg-3 col-xl-3">
                            <div class="">
                                Driving:
                            </div>
                            @if (!empty($driver->truck_id))
                                <a class="" href="/truck/show/{{$driver->truck_id}}">{{App\Truck::find($driver->truck_id)->lable}}</a>
                            @else
                                N/A
                                @if (Auth::user()->role_id > 2)
                                    @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','dingbats'=>'<i class="material-icons md-14 ">add</i>','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                    @endcomponent
                                @endif
                            @endif
                        </div>
                        <div class="timestamp   col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="title">Created at</div>
                            <span>{{$driver->created_at}}</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-body">
            @if ($defaultPickups->count()>0)
                <div class="card-header">
                    <span>
                        <i class="material-icons md-1">business</i>
                        Assigned to pickup from:
                    </span>
                    @foreach ($defaultPickups as $location)
                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$location])
                        @endcomponent,
                    @endforeach
                </div>
            @endif

            <div class="card-header  m-0 justify-around">
                @if ($currentUnassign->count()>0 && $driver->truck_id != null)
                    <i class="material-icons md-1">store_mall_directory</i>
                    <span class="btn btn-sm ml-4">Un-assigned deliveries:</span>
                    @foreach ($currentUnassign as $rideable)
                        <div class="add d-inline">
                            <a class="btn btn-success{{(Auth::user()->role_id==3 && $rideable->type!='Client') ?' d-none':''}} btn-sm text-white h-75" title="{{$rideable->location->name}}" href="/ride/store/{{$rideable->id}}/{{$driver->id}}">
                                <i class="material-icons md-14 text-dark">add</i>
                                {{$rideable->invoice_number}}
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="card-body p-0">
                <table class="table table-compact">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>For</th>
                            <th class="mw-100">#</th>
                            <th>Status</th>
                            <th>Truck</th>
                            <th>Schaduled for</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ongoingRides as $key => $ride)
                            <tr>
                                <td class='pl-2'>{{$ride->id}}</td>
                                @if (!empty($ride->rideable))
                                    <td class="location text-truncate">
                                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])
                                        @endcomponent
                                    </td>
                                    <td class="invoice fixedWidthFont font-weight-bold h4 minw-200">
                                        @if (Auth::user()->role_id > 3 || Auth::user()->id == $ride->rideable->user_id )
                                            @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','dingbats'=>'<i class="material-icons md-16">border_color</i>','style'=>'badge badge-warning mr-1 float-left','iterator'=>$key,'object'=>$ride->rideable,'op1'=>$ride->rideable->type,'op2'=>'','file'=>false,'autocomplateOff'=>true])
                                            @endcomponent
                                        @endif
                                        @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$ride->rideable])
                                        @endcomponent
                                        @if (Auth::user()->role_id > 3 && $ride->rideable->status!='Done' && $ride->rideable->status!='Returned' && $ride->rideable->status!='Return')
                                            <a class="badge badge-primary" href="/rideable/{{$ride->rideable->id}}/Done">&#x2714; Done</a>
                                        @endif
                                    </td>
                                    <td>{{$ride->rideable->status}}</td>
                                @else
                                    <td colspan="3">
                                        The ticket is deleted.
                                        @if (Auth::user()->role_id>3)
                                            <a href="/ride/delete/{{$ride->id}}">remove this line</a>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])
                                    @endcomponent
                                </td>
                                <td>
                                    <div title="{{$ride->created_at->diffForHumans()}}">
                                        {{-- {{$ride->created_at->toFormattedDateString()}}
                                        <span class="text-muted font-weight-light">{{$ride->created_at->toTimeString()}}</span> --}}
                                        @if(!empty($ride->rideable) && $ride->rideable->location->type != 'DropOff' && $ride->rideable->delivery_date!=null)
                                            <span title="{{$ride->rideable->delivery_date.' '.$ride->rideable->shift}}">
                                                <i class="material-icons small">send</i>
                                                @if(App\User::setting('humanDate') && Auth::user()->role_id!=3)
                                                    {{ App\Helper::dateName($ride->rideable->delivery_date)}}
                                                @else
                                                    {{$ride->rideable->delivery_date}}
                                                @endif
                                                <i class="material-icons small">schedule</i>
                                                <span class="text-muted font-weight-light">{{ $ride->rideable->shift}}</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if (Auth::user()->role_id >= 3 && $ride->rideable != null && $ride->rideable->status!='Done' && $ride->rideable->status!='Returned' && $ride->rideable->status!='Return')
                                        <a title="Remove driver from this invoice" class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$ride->rideable->id}}">Detach</a>
                                        @if (Auth::user()->role_id > 3 )
                                            <a title="Returned" class="badge badge-danger" href="/rideable/{{$ride->rideable->id}}/Returned"><i class="material-icons md-14">keyboard_return</i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-dangers">
                            <td colspan="7 bg-black">
                                <div class="d-inline-block pagination-sm">
                                    {{ $finishedRides->links("pagination::bootstrap-4") }}
                                </div>
                            </td>
                        </tr>
                        @foreach ($finishedRides as $key => $ride)
                            <tr>
                                <td class='pl-2'>{{$ride->id}}</td>
                                @if (!empty($ride->rideable))
                                    <td class="location text-truncate">
                                        @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])
                                        @endcomponent
                                    </td>
                                    <td class="invoice fixedWidthFont font-weight-bold h4 minw-200">
                                        @if (Auth::user()->role_id > 3 || Auth::user()->id == $ride->rideable->user_id )
                                            @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','dingbats'=>'<i class="material-icons md-16">border_color</i>','style'=>'badge badge-warning mr-1 float-left','iterator'=>$key,'object'=>$ride->rideable,'op1'=>$ride->rideable->type,'op2'=>'','file'=>false,'autocomplateOff'=>true])
                                            @endcomponent
                                        @endif
                                        @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$ride->rideable])
                                        @endcomponent
                                        @if (Auth::user()->role_id > 3 && $ride->rideable->status!='Done' && $ride->rideable->status!='Returned' && $ride->rideable->status!='Return')
                                            <a class="badge badge-primary" href="/rideable/{{$ride->rideable->id}}/Done">&#x2714; Done</a>
                                        @endif
                                    </td>
                                    <td>{{$ride->rideable->status}}</td>
                                @else
                                    <td class='no-info' colspan="3">
                                        The ticket is deleted.
                                        @if (Auth::user()->role_id>3)
                                            <a href="/ride/delete/{{$ride->id}}">remove this line</a>
                                        @endif
                                    </td>
                                @endif
                                <td class="truck text-truncate">
                                    @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])
                                    @endcomponent
                                </td>
                                <td>
                                    <div title="{{$ride->created_at->diffForHumans()}}">
                                        {{-- {{$ride->created_at->toFormattedDateString()}}
                                        <span class="text-muted font-weight-light">{{$ride->created_at->toTimeString()}}</span> --}}
                                        @if(!empty($ride->rideable) && $ride->rideable->location->type != 'DropOff' && $ride->rideable->delivery_date!=null)
                                            <span title="{{$ride->rideable->delivery_date.' '.$ride->rideable->shift}}">
                                                <i class="material-icons small">send</i>
                                                @if(App\User::setting('humanDate') && Auth::user()->role_id!=3)
                                                    {{ App\Helper::dateName($ride->rideable->delivery_date)}}
                                                @else
                                                    {{$ride->rideable->delivery_date}}
                                                @endif
                                                <i class="material-icons small">schedule</i>
                                                <span class="text-muted font-weight-light">{{ $ride->rideable->shift}}</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if (Auth::user()->role_id >= 3 && $ride->rideable != null && $ride->rideable->status!='Done' && $ride->rideable->status!='Returned' && $ride->rideable->status!='Return')
                                        <a title="Remove driver from this invoice" class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$ride->rideable->id}}">Detach</a>
                                        @if (Auth::user()->role_id > 3 )
                                            <a title="Returned" class="badge badge-danger" href="/rideable/{{$ride->rideable->id}}/Returned"><i class="material-icons md-14">keyboard_return</i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                <div class="pagination">
                                    {{ $finishedRides->links("pagination::bootstrap-4") }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if ($driver->fillups->count()>0)
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
                            @foreach ($driver->fillups as $key => $fillup)
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
        @else
            <div class="card-body">
                No fillup records.
            </div>
        @endif
        @if ($driver->services->count()>1)
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
                    @foreach ($driver->services as $key => $service)
                        <div class="row py-2 mb-1 border">
                            <div class="{{$tr}}">
                                <div class="text-truncate">
                                        {{$service->driver}}
                                </div>
                            </div>
                            <div class="{{$ser}} text-truncate">
                                @if ($service->image!='')
                                    @component('layouts.components.imgtooltip',['modelName'=>'service','model'=>$service])
                                    @endcomponent
                                @endif
                                <strong>{{$service->product}}: </strong>
                                <span title="{{$service->description}}">{{$service->description}}</span>
                            </div>
                            <div class="{{$shop}}">
                                {{$service->shop}}
                                <br>
                                {{$service->mileage}}
                            </div>
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
                                        'file'=>true])
                                    @endcomponent
                                    <a title='Delete' class="badge badge-danger p-0" href="/service/delete/{{$service->id}}"><i class="material-icons">delete_forever</i></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="card-body">
                No service records.
            </div>
        @endif
    </div>


@endsection
