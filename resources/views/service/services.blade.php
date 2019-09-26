@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-light">
            <div class="col-11 h3">Services</div>
            <div class="col-1 p-0 m-0">
                @component('layouts.components.modal',[
                    'modelName'=>'service',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'service',
                    'dingbats'=>'<i class="material-icons">add_box</i>',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
            </div>
        </div>
        <div class="card-body">
            {{-- <div class='row font-weight-light h6'>
            <div class="{{$tr='col-4 col-sm-4 col-md-3 col-lg-3 col-xl-2'}}">Truck<br>Driver</div>
            <div class="{{$ser='col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2'}}">Service/<br>Description</div>
            <div class="{{$shop='col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2'}}">Shop/ <br>Mileage</div>
            <div class="{{$tot='col-4 col-sm-3 col-md-1 col-lg-1 col-xl-2'}} text-truncate"><strong>Total</strong><br>Voucher</div>
            <div class="{{$on='col-4 col-sm-4 col-md-2 col-lg-2 col-xl-2'}}">On</div>
            <div class="{{$ac='col-4 col-sm-5 col-md-2 col-lg-2 col-xl-2'}}">Actions</div>
        </div> --}}
        <div id="accordion">
            @foreach ($trucks as $key => $truck)
                @if ($truck->status==1)
                    <div class="card mb-1">
                        <div class="card-header font-weight-light h6 bg-white" id="{{$truck->id}}">
                            <a class="btn btn-link d-block text-left" data-toggle="collapse" data-target="#col-{{$truck->id}}" aria-expanded="false" aria-controls="col-{{$truck->id}}">
                                @php
                                    $driver = App\Driver::where('truck_id',$truck->id)->first();
                                @endphp
                                {{$truck->lable}} : <span class="font-italic">{{$driver == null ? '' : $driver->fname }}</span>
                            </a>
                        </div>

                        <div id="col-{{$truck->id}}" class="collapse " aria-labelledby="{{$truck->id}}" data-parent="#accordion">
                            <div class="card-body">
                                @foreach ($truck->services as $key => $service)
                                    <li>
                                        <a href="/service/show/{{$service->id}}">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                        {{$service->created_at->diffForHumans()}} <b>{{$service->driver->fname}}</b> took it to get {{$service->description}} done
                                        @ {{$service->mileage}} mi and paid <b>${{$service->total}}</b>
                                    </li>
                                @endforeach
                            </div>
                        </div>
                    </div>
                {{-- @else {{$truck->lable}} --}}
                @endif
            @endforeach

        </div>

    </div>
</div>

@endsection
