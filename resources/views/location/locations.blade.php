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
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location Name</th>
                        <th>Contact Person</th>
                        <th>Type</th>
                        <th>Distance</th>
                        <th>Address</th>
                        <th>Created At<br>/Last Update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $key => $location)
                        <tr>
                            <td>{{$location->id}}</td>
                            <td>
                                <h3>
                                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$location])@endcomponent
                                </h3>
                                <span class="text-muted">
                                    {{$location->phone}}
                                </span>
                            </td>
                            <td>{{$location->person}}</td>
                            <td>{{$location->type}}</td>
                            <td>{{$location->distance}} Mile </td>
                            <td>
                                {{$location->line1}}<br>
                                {{$location->line2}}<br>
                                {{$location->city}}, {{$location->state}} - {{$location->zip}}<br>
                            </td>
                            <td>
                                {{$location->created_at->diffForHumans()}}<br>
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
        </div>
    </div>
@endsection
