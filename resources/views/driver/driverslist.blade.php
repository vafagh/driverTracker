<ul class="list-group" id='driverd'>
    <li class="driver list-group-item py-0 list-group-item-secondary">
        <div class="row m-0 p-0">
            <div class='col-4'></div>
            <div class="col-4">Created at</div>
            <div class='col-2'>Miles Driven</div>
            <div class='col-2'>Total Trip</div>
        </div>
    </li>
    @foreach ($drivers as $key => $driver)
        <li class="list-group-item disabled py-2 active font-weight-bold">{{$driver->fname.' '.$driver->lname}}</li>
        <li class="row m-0 p-0 mb-1 border  border-secondary">
            <div class="col-1 bg-danger p-0">
                <img class="w-100" src="{{($driver->image == null) ? '/img/def.svg' : '/img/driver/'.$driver->image }}" alt="">
            </div>
            <div class="col-11">
                <div class="row mx-0  pt-2">
                    <h3 class="col-3">
                        {{$driver->fname.' '.$driver->lname}}
                    </h3>
                    <div  class="col-5">
                        {{$driver->created_at}}
                    </div>
                    <div  class="col-2">
                        <h2 class="mb-0">{{App\Ride::where('driver_id', $driver->id)->sum('distance')}} </h2>Mile
                    </div>
                    <div  class="col-2">
                        <h2 class="mb-0">{{ App\Ride::where('driver_id', $driver->id)->count() }} </h2>Trip
                    </div>
                </div>
                <div class="row m-0  pb-2">
                    <div class="col-5 ">
                        {{$driver->phone}}
                    </div>
                    <div class="col-7 pt-2">
                        @component('layouts.components.modal',[
                            'modelName'=>'driver',
                            'action'=>'edit',
                            'op1'=>'op1',
                            'op2'=>'driver',
                            'btnSize'=>'small',
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
                            'object'=>'',
                            'iterator'=>$key,
                            'file'=>true])
                        @endcomponent
                        <a class="btn btn-primary btn-sm mb-1" href="/fillups/driver/{{$driver->id}}">Fillups</a>
                        <a class="btn btn-secondary btn-sm mb-1" href="/driver/show/{{$driver->id}}">Ride History</a>
                        <a class="btn btn-primary btn-sm mb-1" href="/driver/delete/{{$driver->id}}">Delete</a>
                    </div>
                </div>
            </div>

        </li>
    @endforeach
</ul>
