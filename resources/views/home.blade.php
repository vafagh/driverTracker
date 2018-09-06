@extends('layouts.app')

@section('content')
    {{-- <div class="card">
    <div class="card-body">
    @component('rideable.rideable',['collection'=> $deliveries,'op1'=>'Client','op2'=>'Delivery','flashId'=>$flashId])
    File Missing!
@endcomponent
<hr>
@component('rideable.rideable',['collection'=> $pickups,'op1'=>'Warehouse','op2'=>'Pickup','flashId'=>$flashId])
File Missing!
@endcomponent
</div>
</div> --}}

<div class="locations card">
    <div class="card-header">Pickups by locations</div>
    <div class="card-body">
        <div class="row d-flex justify-content-around">
            @foreach ($warehouses as $key => $warehouse)
                <div class="card col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 px-0">
                    <div class="card-header text-center mh-20 px-0 py-1 ">
                        @component('layouts.components.tooltip',
                        ['modelName'=>'location','model'=>$warehouse])@endcomponent
                    </div>

                    <div class="card-body px-1">
                        <p class="card-text">
                            <small class="text-muted">
                                Total trip :{{ App\Rideable::where('location_id', $warehouse->id)->count() }}
                            </small>
                            @foreach (App\Rideable::where([
                                ['status','!=','Done'],
                                ['status','!=','Canceled'],
                                ['status','!=','Delete'],
                                ['location_id',$warehouse->id]
                                ])->get() as $key => $value)
                                <div class="fixedWidthFont">
                                    {{$value->invoice_number}}
                                </div>

                            @endforeach
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>
<div class="map card mt-3">
    <div class="card-header">All ongoing rides</div>
    <div class="card-body" style="height:430px">

            @section('head')
                <style>
                      /* Always set the map height explicitly to define the size of the div
                       * element that contains the map. */
                      #map {
                        height: 100%;
                      }
                      /* Optional: Makes the sample page fill the window. */
                      html, body {
                        height: 100%;
                        margin: 0;
                        padding: 0;
                      }
                    </style>

            @endsection

            <div id="map"></div>

            @section('footer-scripts')

                    <script>
                      var map;
                      function initMap() {
                        map = new google.maps.Map(document.getElementById('map'), {
                          zoom: 10,
                          center: new google.maps.LatLng(32.748029, -96.982862),
                          mapTypeId: 'roadmap'
                        });

                        var iconBase = 'http://127.0.0.1:8000/img/driver/small/';
                        var icons = {
                            @foreach (App\Driver::all() as $key => $driver)
                            {{$driver->fname}}: {
                                icon: iconBase + '{{strtolower($driver->fname)}}.png'
                            },
                            @endforeach
                        };

                        var features = [
                              @foreach ($rideables as $key => $rideable)
                                @if (!empty($rideable->location->lat))
                                  {
                                    position: new google.maps.LatLng({{$rideable->location->lat}}, {{$rideable->location->lng}}),
                                    type: '{{$rideable->rides->first()->driver->fname}}'
                                    },
                                @endif
                            @endforeach
                        ];

                        // Create markers.
                        features.forEach(function(feature) {
                          var marker = new google.maps.Marker({
                            position: feature.position,
                            icon: icons[feature.type].icon,
                            map: map
                          });
                        });
                      }
                    </script>
                    <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWE7jcte-d6FLo0rYxQFManjv6rzi0Ysc&callback=initMap">
                    </script>


            @endsection











    </div>
</div>
@endsection
