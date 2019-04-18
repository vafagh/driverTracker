@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-header row m-0 h4 bg-primary text-light">
            <span class="col-10">
                Rideable details
            </span>
            @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'action'=>'edit',
                    'style'=>'badge badge-warning col-2 ',
                    'iterator'=>'',
                    'object'=>$rideable,
                    'op1'=>$rideable->type,
                    'op2'=>$rideable->location->type,
                    'file'=>false,
                    'autocomplateOff'=>true])
                @endcomponent
            @endif
        </div>

        <div class="card-body row  ">
            <div class="Invoice     col-4  col-sm-4  col-md-3 col-lg-2 col-xl-2 m-0 border">
                <div class="label">
                    Part / Invoice:
                </div>
                <div class="fixedWidthFont h3 pt-2">
                    {{$rideable->invoice_number}}
                    {!!($rideable->qty>1) ? '<small><sup class="text-secondary"> x'.$rideable->qty.'</sup></small>':''!!}
                    {!! ($rideable->stock==1) ? '<small><sup class="text-primary"> Stock</sup></small>' : '' !!}
                </div>
            </div>
            <div class="location    col-8  col-sm-8  col-md-5 col-lg-3 col-xl-4 m-0 border">
                <div class="data h3 pt-3">
                    <i class="material-icons">
                        @if ($rideable->type)
                            store_mall_directory
                        @else domain
                        @endif
                    </i>
                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$rideable->location,'class'=>'textIcons'])
                    @endcomponent
                </div>
            </div>
            <div class="status      col-3  col-sm-3  col-md-4 col-lg-2 col-xl-2 m-0 border">
                <div class="label">
                    status:
                </div>
                <div class="data ">
                    {{$rideable->status}}
                </div>
            </div>
            <div class="user        col-3  col-sm-3  col-md-2 col-lg-2 col-xl-2 m-0 border">
                <div class="label">
                    Created by
                </div>
                <div class="data ">
                    {{$rideable->user->name}}
                </div>
            </div>
            <div class="date        col-6  col-sm-6  col-md-5 col-lg-3 col-xl-2 m-0 border">
                <div class="label">
                    created_at:
                </div>
                <div class="data">
                    {{$rideable->created_at}}
                </div>
            </div>
            <div class="delivery    col-12 col-sm-12 col-md-5 col-lg-4 col-xl-4 m-0 border">
                <div class="label">
                    Delivery
                </div>
                <div class="data h3">
                    {{App\Helper::dateName($rideable->delivery_date)}},
                    {{$rideable->shift}}
                </div>
            </div>
            <div class="description col-6  col-sm-7  col-md-8 col-lg-5 col-xl-6 m-0 border">
                <div class="label">
                    description:
                </div>
                <div class="data">
                    {{$rideable->description}}
                </div>
            </div>
            <div class="update      col-6  col-sm-5  col-md-4 col-lg-3 col-xl-2 m-0 border">
                <div class="label">
                    updated_at:
                </div>
                <div class="data">
                    {{$rideable->updated_at}}
                </div>
            </div>
        </div>
        @if ($rideable->rides->count()>0)
            <div class="card-header">
                Rides
            </div>
            <ul class="list-group">
                @foreach ($rideable->rides as $ride)
                    <li class="list-group-item driver" style="background-image: url(/img/driver/{{$ride->driver->image}}); background-position: right top, left top; background-size:44px; background-repeat: no-repeat, repeat;">
                        <span class="d-md-none text-muted">D/T: </span>
                        @if (Auth::user()->role_id > 2 && $loop->last)<a class="badge badge-danger" href="/ride/detach/{{$ride->id}}/{{$rideable->id}}"><i class="material-icons md-16">remove_circle_outline</i></a>
                        @endif
                        @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])
                        @endcomponent
                        <span title="{{$ride->pivot->created_at}}">{{ $ride->pivot->created_at->diffForHumans()}}</span>
                        @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])
                        @endcomponent
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="card-header">
            Record history:
        </div>
        <div class="card-body">
            @foreach (App\Transaction::where('table_name','rideables')->where('row_id',$rideable->id)->orderByDesc('created_at')->get() as $key => $transaction)
                <div class="card mb-1" id='accordion'>
                    <div class="card-header" id="heading{{$key}}">
                        <div class="h5 my-0 row" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                            <a    class="col-6 col-sm-3 col-md-3 col-lg-2" href="/{{$transaction->user->name}}">{{$transaction->user->name}}</a>
                            <span class="col-6 col-sm-3 col-md-3 col-lg-6 {{($transaction->action=='destroy') ? 'text-danger':''}}">{{$transaction->action}}</span>
                            <span class="col-10 col-sm-3 col-md-3 col-lg-2" title="{{$transaction->created_at}}">{{$transaction->created_at->diffForHumans()}}</span>
                        </div>
                    </div>
                    <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                        <div class="card-body">
                            <div class="text-danger">
                                @component('layouts.row',['data' =>$transaction->last_data])
                                @endcomponent
                            </div>
                            <div class="text-success">
                                @component('layouts.row',['data' =>$transaction->new_data])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
