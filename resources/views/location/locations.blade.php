@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-white">
            <div class="col-10 h3 mb-0">
                Locations
            </div>
            <div class="col-2">
                @if (Auth::user()->role_id > 1)
                    @component('layouts.components.modal',[
                        'modelName'=>'location',
                        'action'=>'create',
                        'object'=>null,
                        'op1'=>'op1',
                        'op2'=>'location',
                        'iterator'=>0,
                        'file'=>true])
                    @endcomponent
                @endif
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
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?center={{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}&zoom=9&size=300x100&maptype=roadmap&key=AIzaSyBWE7jcte-d6FLo0rYxQFManjv6rzi0Ysc&markers=size:mid%7Ccolor:0xdd000%7C{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}" alt="{{$location->name}} Maps">
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
                                @if (Auth::user()->role_id > 3)
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
                                @endif
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
