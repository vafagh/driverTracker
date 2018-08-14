<ul class="list-group" id='driverd'>
    <li class="driver list-group-item py-0 list-group-item-secondary">
        <div class="row m-0 p-0 d-none d-md-flex">
            <div class='col-4'></div>
            <div class="col-4 ">Created at</div>
            <div class='col-2'>Miles Driven</div>
            <div class='col-2'>Total Trip</div>
        </div>
    </li>
    @foreach ($drivers as $key => $driver)
        {{-- <li class="list-group-item disabled py-2 active font-weight-bold">
            <a class="text-white" href="/driver/show/{{$driver->id}}">
                {{$driver->fname.' '.$driver->lname}}
            </a>
        </li> --}}
        <li class="row m-0 p-0 mb-3 border  border-secondary">
            <div class="row col-12 m-0 p-0">
                {{-- <div class="col-1 border">1</div><div class="col-1 border">2</div><div class="col-1 border">3</div><div class="col-1 border">4</div><div class="col-1 border">5</div><div class="col-1 border">6</div><div class="col-1 border">7</div><div class="col-1 border">8</div><div class="col-1 border">9</div><div class="col-1 border">10</div><div class="col-1 border">11</div><div class="col-1 border">12</div> --}}
                <div class="col-6 row m-0 p-0">
                    <div class="col-4  col-sm-3 col-md-2 col-lg-1 p-1 ">
                        <a href="/driver/show/{{$driver->id}}">
                            <img class="w-100 mx-auto" src="{{($driver->image == null) ? '/img/driver/def.svg' : '/img/driver/'.$driver->image }}" alt="">
                        </a>
                    </div>
                    <div class="col-8">
                        <div class="h2 name ">{{ $driver->fname }}</div>
                        <div class="h3 fullName">{{ $driver->lname }}</div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 row m-0 p-0 created_at">
                    <div class="col-12 text-center text-muted">{{ $driver->created_at }}</div>
                    <div class="col-6 totalDistance"><h2 class="mb-0">{{ $driver->totalDistance() }}</h2>Mile</div>
                    <div class="col-6  totalTrip"><h2 class="mb-0">{{ $driver->totalTrip() }}</h2>Trip</div>
                </div>
                <div class="col-12 h5 phone row m-0 p-0">
                    <div class="col-6">
                        {!!($driver->phone) ? '<span class="text-muted">&#x2706; </span>'.$driver->phone:''!!}
                    </div>
                    <div class="col-6">
                        @if($driver->truck_id)
                            <span class="text-muted">Driving: </span>{{$truck = App\Truck::find($driver->truck_id)->license_plate}}
                            <a class="btn btn-sm btn-warning" href="/driver/{{$driver->id}}/unassign">&#x2700;</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 pt-2 actions">
                @if (Auth::user()->role_id > 3)
                    @component('layouts.components.modal',[
                        'modelName'=>'driver',
                        'action'=>'edit',
                        'op1'=>'op1',
                        'op2'=>'driver',
                        'btnSize'=>'small',
                        'style'=>'btn btn-warning mb-1 ',
                        'object'=>$driver,
                        'iterator'=>$key,
                        'file'=>true])
                    @endcomponent
                    @component('layouts.components.modal',[
                        'modelName'=>'fillup',
                        'action'=>'create',
                        'op1'=>'op1',
                        'op2'=>'fillup',
                        'btnSize'=>'small',
                        'style'=>'btn btn-success text-light mb-1 ',
                        'object'=>'',
                        'iterator'=>$key,
                        'file'=>true])
                    @endcomponent
                    <a class="btn btn-secondary btn-sm mb-1 ml-1" href="/driver/show/{{$driver->id}}">Info &#x27BE;</a>
                    <a class="btn btn-danger btn-sm mb-1 ml-1" href="/driver/delete/{{$driver->id}}">Del &#x2716;</a>
                @endif
            </div>

        </li>
    @endforeach
</ul>
