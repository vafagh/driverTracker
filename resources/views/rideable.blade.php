@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="card-body">
                @component('layouts.rideable',['collection'=> $rideables,'op1'=>$op1,'op2'=>$op2])
                    File Missing!
                @endcomponent
            </div>
        </div>
    @endsection
