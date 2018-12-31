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
                <a title="Cancel" class="text-danger" href="/rideable/delete/{{$rideable->id}}/">
                    <i class="material-icons">delete_forever</i>
                </a>
            @endif
            @if ($rideable->location->type != 'DropOff')
                @component('layouts.components.modal',['modelName'=>'ride','action'=>'create',
                    'iterator'=>$rideable->id,
                    'object'=>$rideable,
                    'btnSize'=>'small',
                    'style'=>'text-info text-white ',
                    'op1'=>'',
                    'op2'=>'',
                    'dingbats'=>'<i class="material-icons">drive_eta</i> ',
                    'file'=>false])
                @endcomponent
            @endif
            @if ($title=='Droped off')
                <a class="text-primary" title="Done" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i>{{-- {{$title}} --}}</a>
            @endif
        @break

        @case('Returned')
            @if ($user_id == $rideable->user_id)
                <a class="text-primary" title="Make as a done" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i></a>
            @endif
        @break

        @case('DriverDetached')
            @if ($user_id == $rideable->user_id)
                <a title="
                Cancel" class="text-danger" href="/rideable/delete/{{$rideable->id}}/">
                    <i class="material-icons">delete_forever</i>
                </a>
            @endif
            @if ($rideable->location->type != 'DropOff')
                @component('layouts.components.modal',[
                    'modelName'=>'ride',
                    'action'=>'create',
                    'iterator'=>$rideable->id,
                    'object'=>$rideable,
                    'btnSize'=>'small',
                    'style'=>'text-info text-white ','op1'=>'','op2'=>'','dingbats'=>'<i class="material-icons">drive_eta</i> ','file'=>false])
                @endcomponent
            @endif
            @if ($title=='Droped off')
                <a class="" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i>{{-- {{$title}} --}}</a>
            @endif
        @break

        @case('OnTheWay')
            @if ($title != 'Delivered')
                <a title="Parts not available" class="text-danger" href="/rideable/{{$rideable->id}}/NotAvailable">
                    <i class="material-icons">priority_high</i>
                </a>
            @else
                <a title="Returned" class="" href="/rideable/{{$rideable->id}}/Returned"><i class="material-icons">keyboard_return</i></a>
            @endif
            {{-- @if ($user_role != 3)
                <a title="Request warehouse manager to dissmis driver from this ticket" class="text-warning" href="/rideable/{{$rideable->id}}/DeatachReqested"><i class="material-icons">cancel</i></a>
            @endif --}}
            <a class="" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i></a>
        @break

        @case('DeatachReqested')
            @if ($user_role > 3)
                <a title="Done" class="text-primary" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i></a>
            @endif
        @break

        @case('NotAvailable')
            {{-- @if (empty($rideable->rides)) --}}
                @if (($user_role >= 3))
                    <a title="Clear line" class="text-danger" href="/rideable/{{$rideable->id}}/Canceled">
                        <i class="material-icons">clear_all</i>
                    </a>
                @endif
            {{-- @else
                Remove the attached driver --}}
            {{-- @endif --}}
        @break

        @case('CancelReq')
            <a title="Cancel" class="text-danger" href="/rideable/delete/{{$rideable->id}}/">
                <i class="material-icons">delete_forever</i>
            </a>
        @break

        @default
        @if (Auth::user()->role_id > 4)
            <a title="Re Active" class="text-info" href="/rideable/{{$rideable->id}}/Reactived"><i class="material-icons">replay</i></a>
            <a title="Done" class="text-primary" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i></a>
            <a title="Not available" class="text-danger" href="/rideable/{{$rideable->id}}/NotAvailable"><i class="material-icons">priority_high</i></a>
            <a title="Request warehouse manager to dissmis driver from this ticket" class="text-danger" href="/rideable/{{$rideable->id}}/DeatachReqested"><i class="material-icons ">remove_circle_outline</i></a>
            @component('layouts.components.modal',[
                'modelName'=>'ride',
                'action'=>'create',
                'iterator'=>'iterator',
                'object'=>$rideable,
                'btnSize'=>'small',
                'style'=>' p-0 text-info ',
                'op1'=>'',
                'op2'=>'',
                // 'dingbats'=>'&#x2707;',
                'dingbats'=>'<i class="material-icons">drive_eta</i>',
                'file'=>false])
            @endcomponent
            <a title="Delete Ride!" class="text-danger" href="/rideable/delete/{{$rideable->id}}/"><i class="material-icons">delete_forever</i></a>
        @endif
    @endswitch
@endif
