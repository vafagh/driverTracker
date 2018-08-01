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
            @if ($user_id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">Delete</a>@endif
            @if ($user_role == 3 || $user_role == $admin)<a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>@endif
            @if ($user_role > 1 && $title=='Droped off')<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>@endif
        @break

        @case('OnTheWay')
            @if ($user_role == 3 || $user_role == 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>@endif
            @if ($user_id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/DeatachReqested">Cancel this Ride</a>@endif
            @if ($user_role > 1 )<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>@endif
        @break

        @case('Reactived')
            @if ($user_role == 3 || $user_id == $rideable->user_id )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>@endif
            @if ($user_id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/DeatachReqested">Cancel this Ride</a>@endif
            <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>
        @break

        @case('DeatachReqested')
            @if ($user_role == 3)
                >> The creator of this ticket asking you to remove <a class="badge badge-danger" href="/ride/detach/{{$rideable->rides->first()->id}}/{{$rideable->id}}">x</a> driver from this ticket.
            @endif
        @break

        @case('NotAvailable')
            @if ($user_id == $rideable->user_id || $user_role == 3 )<a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-active</a>@endif
            @if ($user_id == $rideable->user_id || $user_role == 3 )<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>@endif
        @break

        @default
            @if (Auth::user()->role_id > 4)
                +<a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-act</a>
                <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>
                <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NA</a>
                <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/DeatachReqested">Deatach</a>
                <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assi</a>
                <a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">Del</a>
                +
            @endif
    @endswitch
@endif
