@extends('layouts.app')

@section('content')
    <div class="fluid-container">
        <div class="row ">
            <div class="side col-2 px-4">
                @component('layouts.navs.accordion')

                @endcomponent
                <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </nav>
        </div>
        <div class=" main col-10">

            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul class="deliveries list-group">
                        <li class="list-group-item disabled py-0 active font-weight-bold">Deliveries</li>
                        <li class="delivery list-group-item py-0 list-group-item-secondary">
                            <div class="row m-0 p-0">
                                <div class='locationName col-3'>Location</div>
                                <div class='InvoiceNumber col-2'>#</div>
                                <div class='InvoiceNumber col-2'>Status</div>
                                <div class="col-5 row p-0 m-0">
                                    <div class='driver col-3'>Driver</div>
                                    <div class="orderCreated col-4">Order Placed on</div>
                                    <div class="truckCreated col-5 bg-primary">Driver Assigned on</div>
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
                    <ul class="Pickups list-group">
                        <li class="list-group-item disabled py-0 active font-weight-bold">Pickups</li>
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
    </div>
</div>
@endsection
