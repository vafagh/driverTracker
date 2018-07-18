@extends('layouts.app')
@section('content')
    <div class="">
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
                @component('layouts.truckslist',['trucks'=> $trucks])
                    File Missing!
                @endcomponent
            </div>
        </div>
    </div>
@endsection