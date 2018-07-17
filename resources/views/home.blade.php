@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="card-body">
                @component('layouts.rideable',['collection'=> $deliveries,'op1'=>'Client','op2'=>'Delivery'])
                    File Missing!
                @endcomponent
                <hr>
                @component('layouts.rideable',['collection'=> $pickups,'op1'=>'Warehouse','op2'=>'Pickup'])
                    File Missing!
                @endcomponent
            </div>
        </div>
    @endsection
