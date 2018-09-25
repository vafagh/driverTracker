@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0">
            Ride with {{$ride->id}} ID number
        </div>

        <div class="card-body">
                <div class="">
                    Driver: @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])
                    @endcomponent
                </div>
            @if (isset($ride->truck))
                <div class="">
                    Truck: @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])
                    @endcomponent
                </div>
            @endif
            @if (isset($ride->rideable))
                <div class="">
                    Invoice/Part Number: @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$ride->rideable])
                    @endcomponent
                </div>
                @if (isset($ride->rideable->location))
                    <div class="">
                        Destination: @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])
                        @endcomponent
                    </div>
                @endif
            @endif
        </div>

        <div class="card-body">
            @foreach (App\Transaction::where('table_name','rides')->where('row_id',$ride->id)->orderByDesc('created_at')->get() as $key => $transaction)
                <div class="card mb-1">
                    <div class="card-header" id="heading{{$key}}">
                        <div class="h5 my-0 row" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                            <a    class="col-6 col-sm-4 col-md-3 col-lg-2" href="/{{$transaction->user->name}}">{{$transaction->user->name}}</a>
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
