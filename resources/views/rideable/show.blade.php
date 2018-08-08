@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-header row m-0 h4 bg-primary text-light">
            Rideable details
        </div>

        <div class="card-body row">
            <div class="col-12 row">
                <div class="col-2">
                    <div class="label">
                        Part / Invoice:
                    </div>
                    <div class="fixedWidthFont h3">
                        <pre>{{$rideable->invoice_number}}</pre>
                    </div>
                </div>
                <div class="col-2">
                    <div class="label">
                        Location:
                    </div>
                    <div class="data h3">
                        {{$rideable->location->name}}
                    </div>
                </div>
                <div class="col-2">
                    <div class="label">
                        type:
                    </div>
                    <div class="data h3">
                        {{$rideable->type}}
                    </div>
                </div>
                <div class="col-2">
                    <div class="label">
                        status:
                    </div>
                    <div class="data h3">
                        {{$rideable->status}}
                    </div>
                </div>
                <div class="col-2">
                    <div class="label">
                        Created by
                    </div>
                    <div class="data h3">
                        {{$rideable->user->name}}
                    </div>

                </div>
                <div class="col-2">
                    <div class="label">
                        description:
                    </div>
                    <div class="data">
                        {{$rideable->description}}
                    </div>
                </div>
                <div class="col-3">
                    <div class="label">
                        created_at:
                    </div>
                    <div class="data">
                        {{$rideable->created_at}}
                    </div>
                </div>
                <div class="col-3">
                    <div class="label">
                        updated_at:
                    </div>
                    <div class="data">
                        {{$rideable->updated_at}}
                    </div>
                </div>
            </div>
        </div>

<div class="card-header">
    Record history:
</div>
        <div class="card-body">
            @foreach (App\Transaction::where('table_name','rideables')->where('row_id',$rideable->id)->get() as $key => $transaction)
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
