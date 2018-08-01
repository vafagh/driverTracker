@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="card-body">
                @component('rideable.rideable',['collection'=> $deliveries,'op1'=>'Client','op2'=>'Delivery','flashId'=>$flashId])
                    File Missing!
                @endcomponent
                <hr>
                @component('rideable.rideable',['collection'=> $pickups,'op1'=>'Warehouse','op2'=>'Pickup','flashId'=>$flashId])
                    File Missing!
                @endcomponent
            </div>
        </div>
        <div class="d-flex justify-content-around">
            @foreach ($warehouses as $key => $warehouse)
                @component('layouts.components.tooltip',['modelName'=>'location','model'=>$warehouse])@endcomponent
            @endforeach
        </div>
    @endsection
