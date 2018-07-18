@extends('layouts.app')
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header row m-0">
                Drivers
            </div>
            <div class="card-body">
                @component('layouts.components.attach',[
                    'modelName'=>'ride',
                    'action'=>'attach',
                    'op1'=>'ride',
                    'op2'=>'rideable',
                    'btnHide'=>'hide',
                    'iterator'=>0,
                    'object'=>$rideable,
                    'file'=>false,
                ])
            @endcomponent
        </div>

    </div>
</div>
@endsection
