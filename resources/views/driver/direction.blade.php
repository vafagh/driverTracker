@extends('layouts.app')
@section('content')

    @section('metas')
        <style>
            #right-panel select, #right-panel input {
                font-size: 15px;
            }

            #right-panel select {
                width: 100%;
            }

            #map {
                height: 100%;
                width: 100%;
                height: 100%;
            }
            #right-panel {
                height: 400px;
            }
        </style>
    @endsection
    <div class="card">

        
        <div class="card-body p-0">
            <ul class="list-group" id='driverd'>
                <li class="row m-0 p-0">
                    <div class="image p-0   col-1 ">
                        <img class="minh-100 rounded" src="{{($driver->image == null) ? '/img/def.svg' : '/img/driver/'.$driver->image }}" alt="">
                    </div>
                    <div class="row p-0 m-0     col-11">
                        <div class="name        col-12  py-1 bg-primary text-light font-weight-bold h3 d-flex justify-content-between">
                            <div class="">
                                {{$driver->fname.' '.$driver->lname}}
                            </div>
                            <div class="row">
                                <a class='col-5 text-light' href="/driver/{{$driver->id}}/today/direction" class='text-white' title='Direction'><i class="material-icons">directions</i></a>
                                <div class="col-7">
                                    @if (Auth::user()->role_id > 2)
                                        @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                        @endcomponent
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="phone       col-12 col-sm-7 col-md-5 col-lg-3 col-xl-3 ">
                            <div class="title">Phone</div>
                            <a class="h3 " href="tel:{{$driver->phone}}" title="Click to Call!">{{$driver->phone}}</a>
                        </div>
                        <div class="miles       col-6 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                            <span class="h2 mb-0">
                                {{$driver->totalDistance()}}
                            </span>Mile
                            <div class="title">Driven</div>
                        </div>
                        <div class="trip        col-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                            <span class="h2 mb-0">
                                {{ $driver->totalTrip() }}
                            </span>Trip
                        </div>
                        <div class="truck       col-12 col-sm-9 col-md-6 col-lg-3 col-xl-3">
                            <div class="">
                                Driving:
                            </div>
                            @if (!empty($driver->truck_id))
                                <a class="" href="/truck/show/{{$driver->truck_id}}">{{App\Truck::find($driver->truck_id)->lable}}</a>
                            @else
                                N/A
                                @if (Auth::user()->role_id > 2)
                                    @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','dingbats'=>'<i class="material-icons md-14 ">add</i>','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                    @endcomponent
                                @endif
                            @endif
                        </div>
                        <div class="timestamp   col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="title">Created at</div>
                            <span>{{$driver->created_at}}</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>


        <div class="card-body p-0">
            <div class="row">
                <div class="col-8">
                    <div id="map"></div>
                </div>
                <div class="col-4">
                    <div id="right-panel">
                        <div>
                            <b>Start:</b>
                            <select id="start">
                                <option value="1628 E Main Street, Grand Prairie, TX 75050">Eagle</option>
                                {{-- <option value="Boston, MA">Boston, MA</option>
                                <option value="New York, NY">New York, NY</option>
                                <option value="Miami, FL">Miami, FL</option> --}}
                            </select>
                            <b>Waypoints:</b> <br>
                            <i>(Ctrl+Click for multiple selection)</i> <br>
                            <select multiple id="waypoints">
                                @php $latsum =0;$lngsum=0; $stopcount=0; @endphp
                                @foreach ($locations as $key => $location)
                                    <option selected value="{{$location->line1.' '.$location->city.' '.$location->state.' '.$location->zip}}">{{$location->longName}}</option>
                                    @php
                                    $latsum = $latsum + $location->lat;
                                    $lngsum = $lngsum + $location->lng;
                                    $stopcount++;
                                    @endphp
                                @endforeach
                            </select>
                            <b>End:</b>
                            <select id="end">
                                <option value="1628 E Main Street, Grand Prairie, TX 75050">Eagle</option>
                            </select>
                            <input type="submit" id="submit">
                        </div>
                    </div>
                </div>
            </div>
            <div id="directions-panel"></div>

        </div>
    </div>
    <script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: {lat: {{$latsum/$stopcount}}, lng: {{$lngsum/$stopcount}}}
        });
        function run() {
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        }
        directionsDisplay.setMap(map);
        run();
        document.getElementById('submit').addEventListener('click', run);

    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
            if (checkboxArray.options[i].selected) {
                waypts.push({
                    location: checkboxArray[i].value,
                    stopover: true
                });
            }
        }

        directionsService.route({
            origin: document.getElementById('start').value,
            destination: document.getElementById('end').value,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];
                var summaryPanel = document.getElementById('directions-panel');
                summaryPanel.innerHTML = '';
                // For each route, display summary information.
                for (var i = 0; i < route.legs.length; i++) {
                    var routeSegment = i + 1;

                    summaryPanel.innerHTML +=   '<div class="list-group">'+
                    '<div class="list-group-item list-group-item-action flex-column align-items-start ">'+
                    '<div class="d-flex w-100 justify-content-between">'+
                    '<span class="h5">' + routeSegment + '</span>'+
                    '<small>' + route.legs[i].distance.text + '</small>'+
                    '</div>'+
                    '<div class="list-group">'+
                    '<div class="list-group-item">From:' + route.legs[i].start_address + '</div>'+
                    '<div class="list-group-item">To:' + route.legs[i].end_address + '</div>'+
                    '</div>'+
                    '<small>Donec id elit non mi porta.</small>'+
                    '</div>'+
                    '</div>';
                }
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API')}}&callback=initMap">
    </script>

@endsection
