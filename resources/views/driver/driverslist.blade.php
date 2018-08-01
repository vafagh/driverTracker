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
        <li class="list-group-item disabled py-2 active font-weight-bold">
            {{$driver->fname.' '.$driver->lname}}
        </li>
        <li class="row m-0 p-0 mb-3 border  border-secondary">
            <div class="col-12 col-sm-1 p-0">
                <img class="w-100 mx-auto" src="{{($driver->image == null) ? '/img/driver/def.svg' : '/img/driver/'.$driver->image }}" alt="">
            </div>
            <div class="col-12 col-sm-11">
                <div class="row mx-0 pt-2">
                    <h3 class="col-6 col-md-3">
                        {{$driver->fname.' '.$driver->lname}}
                    </h3>
                    <div class="col-6 col-md-5">
                        {{$driver->created_at}}
                    </div>
                    <div class="col-6 col-md-2">
                        <h2 class="mb-0">{{App\Ride::where('driver_id', $driver->id)->sum('distance')*2}} </h2>Mile
                    </div>
                    <div class="col-6 col-md-2">
                        <h2 class="mb-0">{{ App\Ride::where('driver_id', $driver->id)->count() }} </h2>Trip
                    </div>
                </div>
                <div class="row m-0 pb-2">
                    <div class="col-5 ">
                        {{$driver->phone}}
                    </div>
                    <div class="col-12 col-sm-7 pt-2">
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
                                <a class="btn btn-info btn-sm mb-1" href="/fillups/driver/{{$driver->id}}">Fillups</a>
                                <a class="btn btn-secondary btn-sm mb-1" href="/driver/show/{{$driver->id}}">Ride History</a>
                                <a class="btn btn-danger btn-sm mb-1" href="/driver/delete/{{$driver->id}}">Delete</a>
                        @endif
                    </div>
                </div>
            </div>

        </li>
    @endforeach
</ul>
