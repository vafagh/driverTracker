@extends('layouts.app')
@section('content')
    <div class="">
        <div class="card mb-4">
            <div class="card-header row m-0 h4 bg-primary text-light">
                Location details
            </div>

            <div class="card-body row">
                <div class="col-12 col-md-8">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class='h3 pl-4'>
                                #{{$location->id}}
                                <img src="/img/location/{{$location->image}}" alt="">

                            </div>
                        </div>
                        <div class="w-25">
                            <div class=" d-inline">
                                distance :
                            </div>
                            <div class='h3 pl-4'>
                                {{$location->distance}}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <div class=" d-inline">
                                Contact Person :
                            </div>
                            <div class='h3 pl-4'>
                                {{$location->person}}
                            </div>
                        </div>

                        <div class="w-25">
                            <div >
                                Phone :
                            </div>
                            <div class='h3 pl-4'>
                                {{$location->phone}}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <div class=" d-inline">
                                Location Name :
                            </div>
                            <div class='h3 pl-4'>
                                {{$location->name}}<br>
                                <span class="h5">
                                    {{$location->longName}}
                                </span>
                            </div>
                        </div>
                        <div class="w-25">
                            <div class=" d-inline">
                                Type :
                            </div>
                            <div class='h3 pl-4'>
                                {{$location->type}}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <div class=" d-inline">
                                Address :
                            </div>
                            <div class='h5 pl-4'>
                                {{$location->line1}}, <br>{{$location->line2}}<br>
                                {{$location->city}}, {{$location->state}} - {{$location->zip}}<br>
                            </div>
                        </div>
                        <div class="">
                            <div>
                                Created At: {{$location->created_at}}
                            </div>
                            <div>
                                Last Update: {{$location->updated_at}}
                            </div>
                            <div>
                                @if (Auth::user()->role_id > 3)
                                    @component('layouts.components.modal',[
                                        'modelName'=>'location',
                                        'action'=>'edit',
                                        'style'=>'badge badge-warning ',
                                        'iterator'=>'',
                                        'object'=>$location,
                                        'op1'=>'',
                                        'file'=>true,
                                        'op2'=>''])
                                    @endcomponent
                                    <a class="badge badge-danger mt-2 mx-auto" href="/location/delete/{{$location->id}}"> Delete</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-12 col-md-4">
                        <a target="_blank" href="https://www.google.com/maps/dir/1628+E+Main+St,+Grand+Prairie,+TX+75050/{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}">
                            <img class="w-100" src="https://maps.googleapis.com/maps/api/staticmap?center={{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}&zoom=10&size=400x400&maptype=roadmap&key=AIzaSyBWE7jcte-d6FLo0rYxQFManjv6rzi0Ysc&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}" alt="{{$location->name}} Maps">
                        </a>
                    </div>
                </div>

            </div>
            @component('rideable.rideable',['collection'=> $location->rideables->sortByDesc('created_at'),'op1'=>$op1,'op2'=>$op2,'flashId'=>''])
                File Missing!
            @endcomponent
        </div>
    @endsection
