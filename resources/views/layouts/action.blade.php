@php
$user_role = Auth::user()->role_id;
$user_id = Auth::user()->id;
$admin = 5;
$title = 'Done';
if($rideable->location->type=='Client')   $title = 'Delivered';
if($rideable->location->type=='Warehouse')  $title = 'Picked up';
if($rideable->location->type=='DropOff')  $title = 'Droped off';
@endphp

@if (($user_id == $rideable->user_id) || $user_role > 2 )
    @switch($action)
        @case('Created')
        @if ($user_id == $rideable->user_id)
            <a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">
                <i class="material-icons md-16">cancel</i>
            </a>
        @endif
        @if (!$rideable->location->type == 'DropOff')
            @component('layouts.components.modal',[
                'modelName'=>'ride',
                'action'=>'create',
                'iterator'=>$rideable->id,
                'object'=>$rideable,
                'btnSize'=>'small',
                'style'=>'badge badge-info text-white ',
                'op1'=>'',
                'op2'=>'',
                'dingbats'=>'<i class="material-icons md-16">drive_eta</i> ',
                'file'=>false])
            @endcomponent
        @endif
        @if ($title=='Droped off')
            <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons md-16">done</i>{{-- {{$title}} --}}</a>
        @endif
        @break
        @case('DriverDetached')
        @if ($user_id == $rideable->user_id)
            <a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">
                <i class="material-icons md-16">cancel</i>
            </a>
        @endif
        @if ($rideable->location->type != 'DropOff')
            @component('layouts.components.modal',[
                'modelName'=>'ride',
                'action'=>'create',
                'iterator'=>$rideable->id,
                'object'=>$rideable,
                'btnSize'=>'small',
                'style'=>'badge badge-info text-white ',
                'op1'=>'',
                'op2'=>'',
                'dingbats'=>'<i class="material-icons md-16">drive_eta</i> ',
                'file'=>false])
            @endcomponent
        @endif
        @if ($title=='Droped off')<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons md-16">done</i>{{-- {{$title}} --}}</a>
        @endif
        @break

        @case('OnTheWay')
        <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>
        @if ($user_role != 3)<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/DeatachReqested"><i class="material-icons md-16">cancel</i></a>
        @endif
        <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons md-16">done</i></a>
        @break

        @case('DeatachReqested')
        @if ($user_role == 3)
            >> The creator of this ticket asking you to remove <a class="badge badge-danger" href="/ride/detach/{{$rideable->rides->first()->id}}/{{$rideable->id}}">&#x2702;</a> driver from this ticket.
        @endif
        @break

        @case('NotAvailable')
        @if (empty($rideable->rides))
            @if (($user_id == $rideable->user_id || $user_role == 3))<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/Canceled"><i class="material-icons md-16">cancel</i></a>
            @endif
        @else
            Remove the driver
        @endif
        @break

        @case('CancelReq')
        <a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/"><i class="material-icons md-16">cancel</i></a>
        @break

        @default
        @if (Auth::user()->role_id > 4)
            <a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-act</a>
            <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons md-16">done</i></a>
            <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NA</a>
            <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/DeatachReqested">Deatach</a>
            @component('layouts.components.modal',[
                'modelName'=>'ride',
                'action'=>'create',
                'iterator'=>'iterator',
                'object'=>$rideable,
                'btnSize'=>'small',
                'style'=>'badge badge-info text-white ',
                'op1'=>'',
                'op2'=>'',
                'dingbats'=>'&#x2707;',
                'file'=>false])
            @endcomponent
            <a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/"><i class="material-icons md-16">cancel</i></a>
        @endif
    @endswitch
@endif
