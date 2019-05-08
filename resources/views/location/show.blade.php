@extends('layouts.app')
@section('content')
    <div>
        <div class="card mb-4">

            <div class="card-body row p-0 m-0">
                <div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-9 row m-0 p-0">
                    <div class="card-header h4 bg-secondary text-light col-12 d-flex justify-content-between minh-50">
                        <span class="">{{$location->longName}}</span>
                        <span>
                            @if (Auth::user()->role_id >= 2)
                                @component('layouts.components.modal',['modelName'=>'location','action'=>'edit','style'=>'badge badge-warning ','iterator'=>'','object'=>$location,'op1'=>'','file'=>true,'op2'=>''])
                                @endcomponent
                            @endif
                            @if ($rideables->count()<1)
                                <a class="badge badge-danger mt-2 mx-auto" href="/location/delete/{{$location->id}}"> Delete</a>
                            @endif
                        </span>
                    </div>
                    <div class="col-3             col-md-6 col-lg-3 col-xl-3 text-truncate">
                        <div class="label text-muted">Code:</div>
                        <div>{{$location->name}}</div>
                    </div>
                    <div class="col-3             col-md-6 col-lg-3 col-xl-3 text-truncate">
                        <div class="label text-muted">Type :</div>
                        <div>{{$location->type}}</div>
                    </div>
                    <div class="col-3             col-md-6 col-lg-3 col-xl-3">
                        <div class="label text-muted text-truncate">distance :</div>
                        <div class="data">{{$location->distance}}</div>
                    </div>
                    <div class="col-3             col-md-6 col-lg-3 col-xl-3">
                        <div class="label text-muted">Trips</div>
                        <div>{{App\Rideable::where('location_id',$location->id)->count()}}</div>
                    </div>
                    <div class="col-12  col-sm-12 col-md-12 col-lg-8 col-xl-6 text-truncate">
                        <div class="label text-muted">Address :</div>
                        <div><a target="_blank" href="https://www.google.com/maps/dir/My+Location/{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}">
                                {{$location->line1}}, {{$location->line2}} {{$location->city}}, {{$location->state}} - {{$location->zip}}
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6    col-md-6 col-lg-4 col-xl-3 text-truncate">
                        <div class="label text-muted">Phone:</div>
                        <div><a href="tel:{{$location->phone}}">{{$location->phone}}</a></div>
                    </div>
                    <div class="col-6 col-sm-6    col-md-6 col-lg-4 col-xl-3 text-truncate">
                        <div class="label text-muted">Person:</div>
                        <div>{{$location->person}}</div>
                    </div>
                    <div class="col-6 col-sm-6    col-md-6 col-lg-4 col-xl-6 text-truncate">
                        <div class="label text-muted">Created At: </div>
                        <div class="data">{{$location->created_at}}</div>
                    </div>
                    <div class="col-6 col-sm-6    col-md-6 col-lg-4 col-xl-6 text-truncate">
                        <div class="label text-muted">Last Update: </div>
                        <div class="data">{{$location->updated_at}}</div>
                    </div>
                </div>
                <div class="col-12 col-sm-5 col-md-6 col-lg-4 col-xl-3 m-0 p-0">
                    <a target="_blank" href="https://www.google.com/maps/dir/My+Location/{{$location->line1}},+{{$location->city}},+{{$location->state}},+{{$location->zip}}">
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
