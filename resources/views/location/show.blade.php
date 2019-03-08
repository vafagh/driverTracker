@extends('layouts.app')
@section('content')
    <div>
        <div class="card mb-4">
            <div class="card-header row m-0 h4 bg-primary text-light">
                {{$location->name}} details
            </div>

            <div class="card-body row">
                <div class="col-12 col-md-7">
                    <table class="table table-fluid">
                        <tr>
                            <th>
                                #{{$location->id}}
                            </th>
                            <td>
                                @component('layouts.components.tooltip',['modelName'=>'location','model'=>$location])
                                @endcomponent
                            </td>
                        </tr>
                        <tr>
                            <th>distance :</th>
                            <td>{{$location->distance}}</td>
                        </tr>
                        <tr>
                            <th>Contact Person :</th>
                            <td>{{$location->person}}</td>
                        </tr>
                        <tr>
                            <th>
                                Phone :
                            </th>
                            <td>{{$location->phone}}
                            </td>
                        </tr>
                        <tr>
                            <th>Location Name :</th>
                            <td>{{$location->name}}</td>
                        </tr>
                        <tr>
                            <th>Location Long Name :</th>
                            <td>{{$location->longName}}</td>
                        </tr>
                        <tr>
                            <th>Type :</th>
                            <td>{{$location->type}}</td>
                        </tr>
                        <tr>
                            <th>Address :</th>
                            <td>{{$location->line1}}, <br>{{$location->line2}}<br>
                                {{$location->city}}, {{$location->state}} - {{$location->zip}}
                            </td>
                        </tr>
                        <tr>
                            <td>Created At: {{$location->created_at}}</td>
                            <td>Last Update: {{$location->updated_at}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @if (Auth::user()->role_id >= 2)
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
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 col-md-5">
                    <a target="_blank" href="https://www.google.com/maps/dir/1628+E+Main+St,+Grand+Prairie,+TX+75050/{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}">
                        <img class="w-100" src="https://maps.googleapis.com/maps/api/staticmap?center={{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}&zoom=10&size=400x400&maptype=roadmap&key={{env('GOOGLE_MAP_API')}}&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}" alt="{{$location->name}} Maps">
                    </a>
                </div>
            </div>
        </div>
        @component('rideable.rideable',['collection'=> $rideables,'op1'=>$op1,'op2'=>$op2,'flashId'=>''])
            File Missing!
        @endcomponent
    </div>
@endsection
