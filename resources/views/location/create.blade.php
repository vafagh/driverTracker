@extends('layouts.app')
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header row m-0">
                Drivers
            </div>
            <div class="card-body">
                @component('layouts.components.create',[
                    'modelName'=>'ride',
                    'action'=>'create',
                    'op1'=>'location',
                    'op2'=>'op2',
                    'btnHide'=>'hide',
                    'iterator'=>0,
                    'object'=>'',
                    'file'=>false,
                ])
            @endcomponent
        </div>

    </div>
</div>
@endsection
