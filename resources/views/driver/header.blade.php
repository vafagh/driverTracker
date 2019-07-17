<div class="card-body p-0">
    <ul class="list-group" id='driverd'>
        <li class="row m-0 p-0">
            <div class="image p-0   col-1 ">
                <img class="minh-100 rounded" src="{{($driver->image == null) ? '/img/def.svg' : '/img/driver/'.$driver->image }}" alt="">
            </div>
            <div class="row p-0 m-0     col-11">
                <div class="name        col-12  py-1 bg-primary text-light font-weight-bold h3 d-flex justify-content-between">
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
                <div class="phone       col-12 col-sm-7 col-md-5 col-lg-3 col-xl-3 ">
                    <div class="title">Phone</div>
                    <a class="h3 " href="tel:{{$driver->phone}}" title="Click to Call!">{{$driver->phone}}</a>
                </div>
                <div class="miles       col-6 col-sm-5 col-md-4 col-lg-2 col-xl-2">
                    <span class="h2 mb-0">
                        {{$driver->totalDistance()}}
                    </span>Mile
                    <div class="title">Driven</div>
                </div>
                <div class="trip        col-6 col-sm-3 col-md-3 col-lg-1 col-xl-1">
                    <span class="h2 mb-0">
                        {{ $driver->totalTrip() }}
                    </span>Trip
                </div>
                <div class="truck       col-12 col-sm-9 col-md-6 col-lg-3 col-xl-3">
                    <div class="">
                        Driving:
                    </div>
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
                <div class="timestamp   col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="title">Created at</div>
                    <span>{{$driver->created_at}}</span>
                </div>
            </div>
        </li>
    </ul>
</div>
