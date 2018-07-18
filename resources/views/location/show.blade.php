@extends('layouts.app')
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header row m-0">
                Location details
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>
                        Location ID : {{$location->id}}
                    </span>
                    <span>
                        Created At: {{$location->created_at}}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>
                        Contact Person : {{$location->person}}
                    </span>
                    <span>
                        Last Update: {{$location->updated_at}}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>
                        Location Name : {{$location->name}}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>
                        Type :      {{$location->type}}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    Phone :     {{$location->phone}}
                </div>
                <div class="d-flex justify-content-between">
                    distance :  {{$location->distance}}
                </div>
                <div class="d-flex justify-content-between">
                    Address :<br>
                    {{$location->line1}}, {{$location->line2}}<br>
                    {{$location->city}}, {{$location->state}} - {{$location->zip}}<br>
                </div>
<div class="">

        @component('layouts.components.modal',[
            'modelName'=>'location',
            'action'=>'edit',
            'style'=>'badge badge-warning ',
            'iterator'=>'',
            'object'=>$location,
            'op1'=>'',
            'op2'=>''
        ])
    @endcomponent
    <br>

    <a class="badge badge-danger mt-2 mx-auto" href="/location/delete/{{$location->id}}"> Delete</a>
    <br>
    <a class="badge badge-info mt-2 mx-auto" href="/rideable/location/{{$location->id}}"> Rides</a>

</div>
            </div>

        </div>
    </div>
@endsection
