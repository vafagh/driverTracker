@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-around">
        <div class="right text-center">
            <a class="text-warning" title="Go one Months backward" href="/?history={{$dt->copy()->submonths(1)->format('Y-m-d')}}&shift={{$shift}}&shift={{$shift}}"><i class="material-icons top-m2 top-m2">fast_rewind</i></a>
            <a class="text-warning" title="Go one Weeks backward" href="/?history={{$dt->copy()->subWeeks(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">skip_previous</i></a>
            <a class="text-warning" title="Go one Days backward" href="/?history={{$dt->copy()->subDays(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">keyboard_arrow_left</i></a>
            <a class="op-04 mor d-inline-block{{$shift == 'Morning' ? ' op-1' :''}}" title="morning" href="/?history={{$history}}&shift=Morning"><span>Morning</span></a>
            <a class="text-success" title="Today" href="/"><i class="material-icons top-m2">today</i></a>
            @php
                $shift=='Morning' ? $dt->addHours(9) : $dt->addHours(13);
            @endphp
            {{-- <span class="h4 lh-15 text-info">{{$dt->format('l jS \\of F Y')}} </span> <span class="h4 text-bold text-warning">{{$shift}}</span> --}}
            <a class="op-04 eve d-inline-block{{$shift == 'Evening' ? ' op-1' :''}}" title="evening" href="/?history={{$history}}&shift=Evening"><span>Evening</span></a>
            <a class="text-info" title="Go one Days forward" href="/?history={{$dt->copy()->addDays(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">keyboard_arrow_right</i></a>
            <a class="text-info" title="Go one Weeks forward" href="/?history={{$dt->copy()->addWeeks(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">skip_next</i></a>
            <a class="text-info" title="Go one Months forward" href="/?history={{$dt->copy()->addmonths(1)->format('Y-m-d')}}&shift={{$shift}}"><i class="material-icons top-m2">fast_forward</i></a>
        </div>
    </div>

    <div class="pickups card">
        <div class="card-header bg-primary text-light d-flex justify-content-between pb-0">
            <span class="p-0 m-0">Back-Orders by locations</span>
            <span class="p-0 m-0"><span class=" h4 text-light">{{$dt->format('l jS \\of F Y')}} </span> <span class="h4 text-bold text-warning">{{$shift}}</span></span>
            <div class="create mt-0">
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'action'=>'create',
                    'op1'=>'Warehouse',
                    'op2'=>'Pickup',
                    'style' => 'p-0 m-0',
                    'dingbats'=>'<i class="material-icons">add_box</i>',
                    'autocomplateOff'=>true])
                @endcomponent
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'action'=>'batch',
                    'dingbats'=>'<i class="material-icons">playlist_add</i>',
                    'autocomplateOff'=>true])
                @endcomponent
                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'name'=>'negatives',
                    'action'=>'button',
                    'dingbats'=>'<i class="material-icons">exposure_neg_1</i>',
                    'autocomplateOff'=>true])
                @endcomponent
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex justify-content-around">
                @foreach ($warehouses as $key => $warehouse)
                    <div class="card col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3{{--App\Helper::col($warehouses->count())--}} mb-4 ml-1 p-0 {{($warehouse->name == 'Other') ? ' border border-warning':''}}">
                        <div class="card-header text-center mh-20 px-0d-flex justify-content-around">
                            @component('layouts.components.tooltip',['modelName'=>'location','model'=>$warehouse])
                            @endcomponent
                        </div>
                        @php
                            $rideables = ($history == $dates['today']) ? $warehouse->rideables->where('delivery_date',$history)->merge($warehouse->rideables->where('delivery_date',null))->all() : $warehouse->rideables->where('delivery_date',$history)
                        @endphp
                        <div class="card-body p-0">
                            @foreach ($rideables as $key => $rideable)
                                <div class="row m-0 p-0 text-uppercase border-bottom mb-1 {{($rideable->location->name == 'Other') ?  (($rideable->user->name==Auth::user()->name) ? "": " text-muted mark "):$rideable->status }}">
                                    <div class="InvoiceNumber col-7 line text-truncate px-0">
                                        <div class="font-70">
                                            @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                                                <div class="d-inline pl-1">
                                                    @component('layouts.components.modal',['modelName'=>'rideable', 'action'=>'edit', 'object'=>$rideable, 'iterator'=>$rideable->id+$key, 'op1'=>$rideable->type, 'op2'=>'', 'dingbats'=>'<i class="material-icons md-16">edit</i>', 'style'=>'text-info pr-0','file'=>false,'autocomplateOff'=>true])
                                                    @endcomponent
                                                </div>
                                            @endif
                                            @php
                                            $ticket = App\Rideable::where('invoice_number',$rideable->description)->first();
                                            @endphp
                                            <div class="InvoiceNumber fixedWidthFont d-inline  {{$rideable->status == 'Done' || $rideable->status == 'Canceled'||$rideable->status == 'NoData' ? 'line-through':''}}"  title="{{$rideable->created_at}}">
                                                @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                                @endcomponent
                                                <span class="small">
                                                    {{$ticket->location->name ??''}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="action col-5 line p-0 text-right pr-2">
                                        <div class="showOnHover text-truncate">
                                            @if ($rideable->status=='Done')
                                                <div class="mt-1">
                                                    {{($rideable->user->name)}}
                                                </div>
                                            @else
                                                @component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'iterator' => $rideable->id,'op1'=>'Warehouse','op2'=>'Pickup'])
                                                @endcomponent
                                            @endif
                                        </div>
                                        <div class="hideOnHover ">
                                            <div class="mt-1 text-truncate">
                                            @if ($rideable->status=='Done')
                                                &#64;{{$rideable->shift}} received
                                            @elseif($rideable->status=='Canceled')
                                                &copf; {{$rideable->status}}
                                            @elseif($rideable->status=='NoData')
                                                <i class="material-icons md-14">wifi_off</i> {{$rideable->status}}
                                            @else
                                                {{($rideable->user->name)}}
                                            @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="card-footer p-0">
                            @if ($warehouse->type=='DropOff')
                                <div class="px-3  text-muted "> Drop Off</div>
                            @else
                                @php
                                $defDriver = App\Driver::find($warehouse->driver_id);
                                $defDriver_fname = (empty($defDriver->fname)) ? null: $defDriver->fname;
                                @endphp
                                <span class="text-muted font-80">
                                    @if (empty($defDriver))
                                        Not assigned yet
                                    @else
                                        Picking by: {{$defDriver_fname}}
                                    @endif
                                </span>
                                <div class="d-flex justify-content-around px-1" id="heading{{$warehouse->id}}">
                                </div>
                                <div>
                                    @if (Auth::user()->role_id >= 3)
                                        @foreach ($activeDrivers as $key => $driver)
                                            <a  class="{{($driver->fname==$defDriver_fname)? "":"disable"}} rounded-circle" href='/location/{{$warehouse->id}}/driver/{{$driver->id}}' title="{{$driver->fname}}">
                                                <img src="/img/driver/small/{{strtolower($driver->fname)}}.png" alt="{{$driver->fname}}">
                                            </a>
                                        @endforeach
                                        <a href='/drivers' title="Assign Driver To Track">
                                            <i class="material-icons md-14">person_add</i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
