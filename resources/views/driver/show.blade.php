@extends('layouts.app')
@section('content')

        <div class="card">
            <div class="card-body p-0">
                <ul class="list-group" id='driverd'>
                    <li class="row m-0 p-0 mb-1 bg-primary text-light  m-0">
                        <div class="image       col-1 ">
                            <img class="pl-2 minh-100 rounded" src="{{($driver->image == null) ? '/img/def.svg' : '/img/driver/'.$driver->image }}" alt="">
                        </div>
                        <div class="row         col-11">
                            <div class="name        col-12 py-1 bg-primary text-light font-weight-bold h3">{{$driver->fname.' '.$driver->lname}}</div>
                            <div class="phone       col-3">
                                <div class="title">Phone</div>
                                <a class="h3 text-light" href="tel:{{$driver->phone}}" title="Click to Call!">{{$driver->phone}}</a>
                            </div>
                            <div class="miles       col-2">
                                <span class="h2 mb-0">
                                    {{$driver->totalDistance()}}
                                </span>Mile
                                <div class="title">Driven</div>
                            </div>
                            <div class="trip        col-1">
                                <span class="h2 mb-0">
                                    {{ $driver->totalTrip() }}
                                </span>Trip
                            </div>
                            <div class="truck       col-3 ">
                                <a class="text-light" href="/truck/show/{{$driver->truck_id}}">{{App\Truck::find($driver->truck_id)->lable}}</a>
                            </div>
                            <div class="timestamp   col-2">
                                <div class="title">Created at</div>
                                <span>{{$driver->created_at}}</span>
                            </div>
                            <div class="action      col-1">
                                @if (Auth::user()->role_id > 2)
                                    @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                    @endcomponent
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="card-header  m-0 justify-around">
                    <span class="inline-block">All Rides</span>
                    <div class="d-inline-block pagination-sm">
                        {{ $finishedRides->links("pagination::bootstrap-4") }}
                    </div>
                    @if ($currentUnassign->count()>0)
                        <span class="btn btn-sm ml-4">Available:</span>
                        <span class='add badge badge-sm badge-success'>Delivery</span>
                        <span class='mr-4 add badge badge-sm badge-info'>Pickup</span>
                        @foreach ($currentUnassign as $rideable)
                            <div class="add d-inline">
                                    <a class="btn btn-{{($rideable->type=='Client')?'success':'info'}} btn-sm text-white h-75" title="{{$rideable->location->name}}" href="/ride/store/{{$rideable->id}}/{{$driver->id}}">
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
                            <tr class="bg-black"><td colspan="4 bg-black"></td></tr>
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
            <div class="card-body">
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
        </div>
@endsection
