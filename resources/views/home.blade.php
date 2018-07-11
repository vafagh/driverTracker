@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">

                <ul class="deliveries list-group" id='deliveries'>
                    <li class="row m-0 py-1 bg-primary text-white rounded-top">
                        <div class=" col-10">
                            <h3 class="m-0 p-0">Deliveries</h3>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#delivery" data-whatever="@mdo">Create New Delivery</button>
                            @component('layouts.create',['id'=>'rideable','op1'=>'Client','op2'=>'delivery']) @endcomponent
                        </div>
                    </li>
                    <li class="delivery list-group-item py-0 list-group-item-secondary">
                        <div class="row m-0 p-0">
                            <div class="col-6 row m-0">
                                <div class=' col-5'>location</div>
                                <div class=' col-3'>#invoice</div>
                                <div class=' col-4'>status</div>
                            </div>
                            <div class="col-6 row m-0">
                                    <div class=' col-3'>driver</div>
                                    <div class=' col-3'>Vehicle</div>
                                    <div class=" col-3">Order</div>
                                    <div class=" col-3">Assigned</div>
                            </div>
                        </div>
                    </li>
                    @foreach ($deliveries as $delivery)
                        @component('layouts.rideable',['rideable'=> $delivery])
                            File Missing!
                        @endcomponent
                    @endforeach
                </ul>
                <hr>
                <ul class="Pickups list-group" id='pickups'>
                    <li class="row m-0 py-1 bg-primary text-white rounded-top">
                        <div class=" col-10">
                            <h3 class="m-0 p-0">Pickups</h3>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#pickup" data-whatever="@pick">Create New Pickup</button>
                            @component('layouts.create',['id'=>'rideable','op1'=>'Warehouse','op2'=>'pickup']) @endcomponent
                        </div>
                    </li>
                    <li class="pickup list-group-item py-0 list-group-item-secondary">
                        <div class="row m-0 p-0">
                            <div class='locationName col-3'>Location</div>
                            <div class='InvoiceNumber col-2'>#</div>
                            <div class='driver col-2'>Driver</div>
                            <div class="orderTime col-2">Order Placed on</div>
                            <div class="orderTime col-3">Driver Assigned on</div>
                        </div>
                    </li>
                    @foreach ($pickups as $pickup)
                        @component('layouts.rideable',['rideable'=> $pickup])
                            File Missing!
                        @endcomponent
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
