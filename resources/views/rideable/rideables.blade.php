@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="card-body p-0">
                @component('rideable.rideable',['collection'=> $rideables,'op1'=>$op1,'op2'=>$op2,'flashId'=>$flashId])
                    File Missing!
                @endcomponent
            </div>
        </div>
    @endsection
