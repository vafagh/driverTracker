<ul class="row m-0 p-0" id='driverd'>

    @foreach ($drivers as $key => $driver)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-2{{($driver->working)?'':' not-working'}}">
            <div class="card">
                <div class="card-img h-50">
                    <a href="/driver/show/{{$driver->id}}">
                        <img class="w-100" src="{{($driver->image == null) ? '/img/driver/def.svg' : '/img/driver/'.$driver->image }}" alt="">
                    </a>
                </div>
                <div class="card-header disabled py-2 active font-weight-bold">
                    <a class="h3" href="/driver/show/{{$driver->id}}">
                        {{$driver->fname}}
                    </a>
                </div>
                <div class="card-body p-1">
                    <div class="row col-12 m-0 p-0">
                        <div class="col-6 row m-0 p-0">
                            <div>
                                <div class="h4 fullName">{{ $driver->lname }}</div>
                            </div>
                        </div>
                        <div class="created_at row mb-2">
                            <div class="col-12 text-center text-muted">{{ $driver->created_at->toFormattedDateString() }}</div>
                            {{-- <div class="col-6 totalDistance"><div class="h3 mb-0">{{ $driver->totalDistance() }}</div>Mile</div> --}}
                            <div class="col-6 totalTrip"><div class="h3 mb-0">{{ $driver->totalTrip() }}</div>Trip</div>
                            <div class="col-12">
                                {!!($driver->phone) ? '<span class="text-muted">&#x2706; </span><a href="tel:+1'.$driver->phone.'">'.$driver->phone.'</a>':''!!}
                            </div>
                            <div class="col-12">
                                @if($driver->truck_id)
                                    <div class="text-muted">Driving: </div>
                                    <div class="text-truncate h4 text-primary">
                                        {{$truck = App\Truck::find($driver->truck_id)->license_plate}}
                                        <a title="Remove Driver-Truck Joint" href="/driver/{{$driver->id}}/unassign"><i class="material-icons text-danger md-16">lock_open</i></a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="col-12 actions p-0">
                        @if (Auth::user()->role_id > 2)
                            @component('layouts.components.modal',[
                                'modelName'=>'driver',
                                'action'=>'edit',
                                'op1'=>'op1',
                                'op2'=>'driver',
                                'btnSize'=>'small',
                                'style'=>'badge badge-warning mb-1 ',
                                'object'=>$driver,
                                'dingbats'=>'<i class="material-icons md-16">edit</i>',
                                'iterator'=>$key,
                                'file'=>true])
                            @endcomponent
                            @component('layouts.components.modal',[
                                'modelName'=>'fillup',
                                'action'=>'create',
                                'op1'=>'op1',
                                'op2'=>'fillup',
                                'btnSize'=>'small',
                                'style'=>'badge badge-success  text-light mb-1 ',
                                'object'=>'',
                                'dingbats'=>'<i class="material-icons md-16">local_gas_station</i>',
                                'iterator'=>$key,
                                'file'=>true])
                            @endcomponent
                            {{-- <a class="badge badge-secondary  mb-1 ml-1" href="/driver/show/{{$driver->id}}">Info &#x27BE;</a> --}}
                        @endif
                        @if (Auth::user()->role_id > 3 && $driver->services->count()==0 && $driver->fillups->count()==0 && $driver->rides->count()==0)
                            <a class="badge badge-danger mb-1 ml-1" href="/driver/delete/{{$driver->id}}"><i class="material-icons md-16">person_add_disabled</i></a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</ul>
