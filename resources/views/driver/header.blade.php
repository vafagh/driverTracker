<div class="card-body p-0">
    <ul class="list-group" id='driverd'>
        <li class="row m-0">
            <div class="name col-12 py-1 bg-primary text-light font-weight-bold h3 d-flex justify-content-between">
                    <div class="">
                        {{$driver->fname.' '.$driver->lname}}
                    </div>
                    <div class="row">
                        <a class='col-2 text-light' href="/driver/{{$driver->id}}/today/Morning/direction" title='Morning Direction'><i class="material-icons">directions</i></a>
                        <a class='col-2 text-warning' href="/driver/{{$driver->id}}/today/Evening/direction" title='Evening Direction'><i class="material-icons">directions</i></a>
                        <div class="col-8">
                            @if (Auth::user()->role_id > 2)
                                @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                @endcomponent
                            @endif
                        </div>
                    </div>
                </div>
            <div class="col-12 row m-0 p-0">
                <div class="image   col-4 col-sm-3 col-md-2 col-lg-2  col-xl-1 pr-0 m-auto">
                    <div class="pr-1">
                        <img class="minh-100 rounded" src="{{($driver->image == null) ? '/img/def.svg' : '/img/driver/'.$driver->image }}" alt="">
                    </div>
                    <div class="trip p-1">
                        <span class="h5 mb-0">
                            {{ $driver->totalTrip() }}
                        </span>
                        <span class="title"> Trip</span>
                    </div>
                </div>
                <div class="row m-0 p-0 col-8 col-sm-9 col-md-10 col-lg-10 col-xl-10 ">
                    <div class="phone       col-12 col-sm-12 col-md-12 col-lg-6 col-xl-12 ">
                        <div class="title">Phone</div>
                        <a class="h4" href="tel:{{$driver->phone}}" title="Click to Call!">{{$driver->phone}}</a>
                    </div>
                    {{-- <div class="miles       col-3 col-sm-6 col-md-3 col-lg-2 col-xl-2">
                        <span class="h2 mb-0">
                        {{$driver->totalDistance()}}
                    </span>
                    <div class="title"> Mile Driven</div>
                </div> --}}
                    <div class="truck       col-12 col-sm-12 col-md-7 col-lg-6  col-xl-6 ">
                        <span class='d-sm-inline d-md-block'>Driving:</span>
                        @if (!empty($driver->truck_id))
                            <a class="" href="/truck/show/{{$driver->truck_id}}">{{App\Truck::find($driver->truck_id)->lable}}</a>
                        @else
                            N/A
                            @if (Auth::user()->role_id > 2)
                                @component('layouts.components.modal',['modelName'=>'driver','action'=>'edit','op1'=>'op1','op2'=>'driver','dingbats'=>'<i class="material-icons md-14 ">add</i>','btnSize'=>'small','object'=>$driver,'iterator'=>'','file'=>true])
                                @endcomponent
                            @endif
                        @endif
                    </div>
                    <div class="timestamp   col-12 col-sm-12 col-md-5 col-lg-12 col-xl-6 ">
                        <div class="d-sm-inline d-md-block">
                            Created at:
                        </div>
                        <span>{{$driver->created_at}}</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
