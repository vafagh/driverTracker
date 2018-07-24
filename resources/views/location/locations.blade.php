@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0">
            <div class="col-10">
                Locations
            </div>
            <div class="col-2">
                @component('layouts.components.modal',[
                    'modelName'=>'location',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'location',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
            </div>

        </div>
        <div class="card-body">
            <div class="mt-2 row">
                <div class="col-5 mx-auto pagination">
                    {{ $locations->links("pagination::bootstrap-4") }}
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Map</th>
                        <th>Last Update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $key => $location)
                        <tr>
                            <td>{{$location->id}}</td>
                            <td>
                                <div>@component('layouts.components.tooltip',['modelName'=>'location','model'=>$location,'element'=>'h3'])@endcomponent</div>
                                <div>{{$location->longName}}</div>
                                <div>{{$location->person}}</div>
                            </td>
                            <td>
                                <div class="text-muted">{{$location->phone}}</div>
                                <div>{{$location->type}}</div>
                                <div>{{$location->distance}} Mile </div>
                            </td>
                            <td>
                                <a target="_blank" href="https://www.google.com/maps/dir/1628+E+Main+St,+Grand+Prairie,+TX+75050/{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}">
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}&zoom=10&size=300x100&maptype=roadmap&key=AIzaSyAlAXEyx7r3mJD8SnWtkh7vOd_Tf5ZA8pc" alt="{{$location->name}} Maps">
                                </a>
                            </td>
                            <td>
                                {{$location->line1}}<br>
                                {{$location->line2}}<br>
                                {{$location->city}}, {{$location->state}} - {{$location->zip}}<br>
                            </td>
                            <td>
                                {{-- {{$location->created_at->diffForHumans()}}<br> --}}
                                {{$location->updated_at->diffForHumans()}}
                            </td>
                            <td>
                                @component('layouts.components.modal',[
                                    'modelName'=>'location',
                                    'action'=>'edit',
                                    'style'=>'badge badge-warning ',
                                    'iterator'=>$key,
                                    'object'=>$location,
                                    'op1'=>'',
                                    'op2'=>''])
                                @endcomponent
                                <br>

                                <a class="badge badge-danger mt-2 mx-auto" href="/location/delete/{{$location->id}}"> Delete</a>
                                <br>
                                <a class="badge badge-info mt-2 mx-auto" href="/rideable/location/{{$location->id}}"> Rides</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 row">
                <div class="col-8 mx-auto pagination-lg">
                    {{ $locations->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
@endsection
