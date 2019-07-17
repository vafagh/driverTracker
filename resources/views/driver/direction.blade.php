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

        @component('driver.header',['driver'=>$driver])
        @endcomponent

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

            @component('rideable.lines',
            [
                'driver'=>$driver,
                'ongoingRides' => $ongoingRides,
                'finishedRides' => false,
                'defaultPickups' => false,
                'currentUnassign' => false,
                'print' => true
            ])
            @endcomponent
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
                        '<div class="row">'+
                            '<div class="h5 col-1">' + routeSegment + '</div>'+
                            '<div class="d-flex w-100 justify-content-between col-10">'+
                                    '<div class="col-6">From:' + route.legs[i].start_address + '</div>'+
                                    '<div class="col-6">To:' + route.legs[i].end_address + '</div>'+
                            '</div>'+
                            // '<small class="col-12">Donec id elit non mi porta.</small>'+
                            '<div  class="col-1"><small>' + route.legs[i].distance.text + '</small></div>'+
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
