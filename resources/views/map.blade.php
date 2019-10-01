<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('metas')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?082818130624" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
    //Static google map hover load
    function loadStatImg(src,imageTarget){
        var list = document.getElementsByClassName(imageTarget);
        for(var i=0;i<list.length;i++){
            list[i].src=src;
        }
    }
    </script>
    <!-- head yield  -->
    @yield('head')

</head>
<body{!! (Request::is('map')==1) ? ' onload="initialize()"':''!!}>
<div id="app">

    <div class=" mx-auto p-0">
        <div class="">
            <div class="map ">
                <div class="" style="height:600px">
                    <div id="default" style="width:100%; height:100%"></div>
                    @section('footer-scripts')

                    <script type="text/javascript">
                        var locations = [
                            @foreach ($spots as $key => $location)
                                @if (!empty($location->lat))
                                    @php
                                        $count--;
                                        $qty = ($location->type != 'Warehouse') ? $location->rideables->whereIn('status',App\Helper::filter('ongoing'))->where('shift',$shift)->count() : 1;
                                    @endphp
                                    ["{{title_case($location->name)}}",{{$location->lat}},{{$location->lng}},{{$location->id}},"{{($qty>1 || empty($qty) ) ? ' x'.$qty : "" }}","{{(empty($location->driver_id)) ? "notAssigned".$location->type : App\Driver::find($location->driver_id)->fname.$location->type }}","{{$location->type}}","{{$location->line1." ".$location->city.' '.$location->state.' '.$location->zip}}"]{{($loop->last)?'':','}}
                                @endif
                            @endforeach
                        ];
                        var icons = {
                            @foreach (App\Driver::all() as $key => $driver)"{{$driver->fname}}Warehouse": {"icon": "/img/driver/small/{{strtolower($driver->fname)}}Warehouse.png", "type":"FORWARD_CLOSED_ARROW"},
                            "{{$driver->fname}}Client": {"icon": "/img/driver/small/{{strtolower($driver->fname)}}Client.png", "type":"BACKWARD_CLOSED_ARROW"},
                            @endforeach"notAssigned": {"icon": "/img/driver/small/notAssigned.png", "type":"BACKWARD_CLOSED_ARROW"},
                            "notAssignedWarehouse": {"icon": "/img/driver/small/notAssignedWarehouse.png", "type":"FORWARD_CLOSED_ARROW"},
                            "notAssignedClient": {"icon": "/img/driver/small/notAssignedClient.png", "type":"BACKWARD_CLOSED_ARROW"},
                            "notAssignedDropOff": {"icon": "/img/driver/small/notAssignedDropOff.png", "type":"CIRCLE"},
                            "notAssignedPickup": {"icon": "/img/driver/small/notAssignedPickup.png", "type":"FORWARD_CLOSED_ARROW"}
                        }

                        function initialize() {
                            var myOptions = {
                                // center: new google.maps.LatLng({{env('STORE_LAT')}}, {{env('STORE_LNG')}}),
                                center: new google.maps.LatLng("33.222222","-95.969696"),
                                zoom: 10,
                                scaleControl: true,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
                            var map = new google.maps.Map(document.getElementById("default"), myOptions);

                            setMarkers(map,locations);

                            var simplePoly = [
                                new google.maps.LatLng({{env('STORE_LAT')}}, {{env('STORE_LNG')}}),
                                new google.maps.LatLng({{env('STORE_LAT')}}, {{env('STORE_LNG')}})
                            ];
                            var flightPath = new google.maps.Polyline({
                                path: simplePoly,
                                editable: true,
                                strokeColor: '#FF0000',
                                strokeOpacity: 1.0,
                                strokeWeight: 2,
                                map: map
                            });
                            @if ($cluster>0)
                                var markerCluster = new MarkerClusterer(map, markers,
                                        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                            @endif
                        }
                        var markers = [];
                        function setMarkers(map,locations){
                            var marker, i
                            for (i = 0; i < locations.length; i++)
                            {
                                var store = locations[i][0]
                                var lat = locations[i][1]
                                var long = locations[i][2]
                                var location_id = locations[i][3]
                                var ridesCount =  locations[i][4]
                                var driver =  locations[i][5]
                                var type =  locations[i][6]
                                var add =  locations[i][7]
                                latlngset = new google.maps.LatLng(lat, long);
                                numberMarkerImg = {
                                    url: icons[driver].icon,
                                    // size: new google.maps.Size(20, 32),
                                    // scaledSize: new google.maps.Size(20, 32),
                                    labelOrigin: new google.maps.Point(10, 40)
                                };
                                labelMaker = {
                                    text: store+ridesCount,
                                    color: "#000",
                                    fontSize: "16px",
                                    fontWeight: "bold",
                                    labelClass: "mapMarkerLabel", // your desired CSS class
                                    labelInBackground: true
                                }
                                var marker = new google.maps.Marker({
                                    map: map,
                                    anchorPoint: google.maps.Point(50, 50),
                                    animation: google.maps.Animation.DROP,
                                    draggable: true,
                                    position: latlngset,
                                    icon: numberMarkerImg,
                                    // opacity: 0.9,
                                    label: labelMaker
                                });

                                map.setCenter(marker.getPosition())

                                var content = "<h4><a href='/location/show/" + location_id + "' target='_blank' width='{{$activeDrivers->count()*20}}px' class='d-block'>" + store + "</a></h4>"+
                                // add+"<br>"+
                                "<div class=''>"+
                                @foreach ($activeDrivers as $key => $driver)
                                "<a class='"+('{{$driver->fname."Client"}}' == driver ? "border" :"no-border") + "' href='/location/"+location_id+"/{{$driver->id}}/{{$delivery_date}}/{{$shift}}{{($cluster>0)?'?cluster=1':''}}'>"+
                                "<img class='d-inline-block' src='/img/driver/small/{{strtolower($driver->fname)}}.png' alt='{{$driver->fname}}'>"+
                                "</a>"+
                                 @endforeach
                                 "<a class='"+('noAssignedClient' == driver ? 'border' :'no-border') + "' href='/location/clear/" + location_id + "{{($cluster>0)?'?cluster=1':''}}'>"+
                                 "<img class='d-inline-block' src='/img/driver/small/notAssignedClient.png' alt='?'>"+
                                 "</a>"+
                                '</div>'

                                var infowindow = new google.maps.InfoWindow()
                                google.maps.event.addListener(marker,'click',(function(marker,content,infowindow){
                                    return function() {
                                        infowindow.setContent(content);
                                        infowindow.open(map,marker);
                                    };
                                })(marker,content,infowindow));
                                markers.push(marker);
                            }
                        }


                    </script>
                     <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API')}}"></script>
                    @endsection
                </div>

                <div class="9d-none">All ongoing rides <sup> Exclude {{$count}} ride without geo location</sup></div>
                <nav class="navbar navbar-expand-md navbar-light navbar-laravel p-0 border">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <h1>{{ config('app.name', 'Tracker') }}</h1>
                        </a>
                        @if (Auth::check() && env('APP_DEBUG')==true)
                            @if (Auth::user()->role_id >3)
                                <span class="badge badge-pill badge-danger position-fixed zindex-tooltip m-1" >
                                    <span class='d-sm-none d-md-none d-lg-none d-xl-none'>xs</span>
                                    <span class='d-none d-sm-inline d-md-none d-lg-none d-xl-none'>sm</span>
                                    <span class='d-none d-sm-none d-md-inline d-lg-none d-xl-none'>md</span>
                                    <span class='d-none d-sm-none d-md-none d-lg-inline d-xl-none'>lg</span>
                                    <span class='d-none d-sm-none d-md-none d-lg-none d-xl-inline'>xl</span>
                                </span>
                            @endif
                        @endif
                        <div class="collapse navbar-collapse pl-sm-3" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            @guest
                                Please log-in.
                            @else
                                <ul class="navbar-nav mr-auto">
                                    @component('layouts.menu',['trigger' =>'above'])
                                    @endcomponent
                                </ul>
                            @endguest

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li> --}}
                                @else
                                    <li class="nav-item d-md-none d-xl-inline">
                                        <form method="get" action="/search/">
                                            <div class="d-block p-2">
                                                <input name="q" class="form-control d-inline-block" type="text" placeholder="Search...">
                                                {{-- <button class="form-control btn d-inline w-25 mb-1" type="submit">Search</button> --}}
                                            </div>
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li class="nav-item dropdown d-none d-sm-inline d-xl-none dropup">
                                        <a id="searchDropdown" class="nav-link dropdown-toggle pt-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            Search <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="searchDropdown">
                                            <form method="get" action="/search/">
                                                <div class="d-block p-2">
                                                    <input name="q" class="form-control d-inline-block" type="text" placeholder="Search...">
                                                    <!--<button class="form-control btn d-inline w-25 mb-1" type="submit">Search</button>-->
                                                </div>
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>

                                    {{-- comment it  --}}
                                    <li class="nav-item dropdown dropup">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle pt-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                Setting
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                                <li class="nav-item line">
                                    <a class="nav-link showOnHover" href="?{{time()}}" title="Reload page">
                                        <i class="material-icons">refresh</i>
                                        <span class="nav-link hideOnHover text-info fixedWidthFont h4 p-0 m-0">
                                            <span id="countdown"></span>"
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="fluid-container row mx-auto p-0">
                    <div class="main col-lg-12 col-xl-12 mt-1">
                        @if (session('info'))
                            <div class="alert alert-info mt-3 mx-auto">{{ session('info') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mt-3 mx-auto">{{ session('error') }}</div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning mt-3 mx-auto">{{ session('warning') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success mt-3 mx-auto">{{ session('success') }}</div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-info mt-3 mx-auto">{{ session('status') }}</div>
                        @endif

                        @yield('content')

                        <div class="d-flex justify-content-between">
                            <span>
                                Total stops: {{$spots->count()}}
                            </span>
                            <div class="">
                                @if (Auth::user()->role_id >3)
                                    <a href="/location/clear/def" class="text-success">
                                        <i class="material-icons">clear_all</i>
                                        Clear def
                                    </a>

                                    <a href="/location/clear/thisShiftOnGoingRides?date={{$delivery_date}}&shift={{$shift}}" class="text-danger">
                                        <i class="material-icons">clear_all</i>
                                        Clear Map
                                    </a>
                                @endif
                                <span>
                                    <a href="?delivery_date={{$delivery_date}}&shift={{$shift}}{{($cluster>0)?'':'&cluster=1'}}">
                                        {!!($cluster>0)?'<i class="material-icons">control_camera</i>Turn cluster off':'<i class="material-icons">games</i>Turn cluster on'!!}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div  class="drivers col-12 row m-0 p-0 card-group">
                                @foreach ($activeDrivers as $key => $driver)
                                    <div class="card">
                                        <div class="card-header py-1">
                                            {{$driver->fname}}
                                        </div>
                                        <ol class="card-body">
                                            @foreach ($driver->rides->where('delivery_date', $delivery_date)->where('shift', $shift) as $key => $ride)
                                                <li>{{$ride->rideable->location->name}}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endforeach
                            </div>
                            <div class="unassigned col-6">
                                <div class="">
                                    Total unassign: {{$unassign->count()}}
                                </div>
                                @if ($unassign->count()>0)
                                    <ol>
                                        @foreach ($unassign as $key => $unassignRideable)
                                            <li title="{{$unassignRideable->status}} ">
                                                <b> {{$unassignRideable->invoice_number}} |
                                                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$unassignRideable->location])
                                                    @endcomponent</b>
                                                    {{-- in {{$unassignRideable->location->line1}} {{$unassignRideable->location->city}} {{$unassignRideable->location->zip}} --}}
                                            </li>
                                        @endforeach
                                @else
                                    Perfect, All assigned.
                                @endif
                                    </ol>
                            </div>
                            <div class="assigned col-6">
                                <div class="">
                                    Total assigned: {{$assigned->count()}}
                                </div>
                                @if ($assigned->count()>0)
                                    <ol>
                                        @foreach ($assigned as $key => $assignedRideable)
                                            <li title="{{$assignedRideable->status}} ">
                                                <b> {{$assignedRideable->invoice_number}} |
                                                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$assignedRideable->location])
                                                    @endcomponent
                                                </b>
                                            </li>
                                        @endforeach
                                @else
                                    Start assign by clicking on the map marker and driver faces.
                                @endif
                                    </ol>
                            </div>
                        </div>

                    </div>



                    <div class="side col-lg-12  col-xl-2 sticky-top pt-4 mt-3 p-0">
                        @include('layouts.side')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@yield('footer-scripts')
</body>
</html>
