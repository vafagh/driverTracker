@php
    $user_role = Auth::user()->role_id;
    $user_id = Auth::user()->id;
    $admin = 5;
    $title = 'Done';
    if($rideable->location->type=='Client')   $title = 'Delivered';
    if($rideable->location->type=='Warehouse')  $title = 'Picked up';
    if($rideable->location->type=='DropOff')  $title = 'Droped off';
@endphp

@if (($user_role == 2 && $user_id == $rideable->user_id) || $user_role > 2 )
    @switch($action)
        @case('Created')
            @if ($user_id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">&#x2716;Del</a>@endif
            @if ($user_role == 3 || $user_role == $admin)
                @component('layouts.components.modal',[
                    'modelName'=>'ride',
                    'action'=>'create',
                    'iterator'=>'iterator',
                    'object'=>$rideable,
                    'btnSize'=>'small',
                    'style'=>'badge badge-info text-white ',
                    'op1'=>'',
                    'op2'=>'',
                    'dingbats'=>'&#x2707; Assign',
                    'file'=>false
                ])
                @endcomponent
            @endif
            @if ($user_id == $rideable->user_id)<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/CancelReq">&#x270B; Cancel</a>@endif
            @if ($user_role > 1 && $title=='Droped off')<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">&#x2714; {{$title}}</a>@endif
        @break

        @case('OnTheWay')
            @if ($user_role == 3 || $user_role == 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>@endif
            @if ($user_id == $rideable->user_id)<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/DeatachReqested">&#x270B; Cancel</a>@endif
            @if ($user_role > 1 )<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">&#x2714; {{$title}}</a>@endif
        @break

        @case('Reactived')
            @if ($user_role == 3 || $user_id == $rideable->user_id )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>@endif
            @if ($user_id == $rideable->user_id)<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/DeatachReqested">&#x270B; Cancel</a>@endif
            <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">&#x2714; {{$title}}</a>
        @break

        @case('DeatachReqested')
            @if ($user_role == 3)
                >> The creator of this ticket asking you to remove <a class="badge badge-danger" href="/ride/detach/{{$rideable->rides->first()->id}}/{{$rideable->id}}">&#x2702;</a> driver from this ticket.
            @endif
        @break

        @case('NotAvailable')
            @if ($user_id == $rideable->user_id || $user_role == 3 )<a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-active</a>@endif
            @if ($user_id == $rideable->user_id || $user_role == 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/Canceled">&#x270B; Cancel</a>@endif
        @break

        @case('CancelReq')
                @if ($user_role >= 3 || $user_role == 3 )<a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">&#x2716;</a>@endif
        @break

        @default
            @if (Auth::user()->role_id > 4)
                +<a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-act</a>
                <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">&#x2714; {{$title}}</a>
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
                    'file'=>false
                ])
                @endcomponent
                <a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">Del</a>
                +
            @endif
    @endswitch
@endif
