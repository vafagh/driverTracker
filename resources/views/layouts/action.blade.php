@php
    $user_role = Auth::user()->role_id;
    $title = 'Done';
    if($rideable->location->type=='Client')   $title = 'Delivered';
    if($rideable->location->type=='Warehouse')  $title = 'Picked up';
    if($rideable->location->type=='DropOff')  $title = 'Droped off';
@endphp

@if ((Auth::user()->role_id == 2 && Auth::user()->id == $rideable->user_id) || Auth::user()->role_id > 2 )
@switch($action)
    @case('Created')
        @if (Auth::user()->id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/delete/{{$rideable->id}}/">Delete</a>@endif
        @if ($user_role == 3 )<a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>@endif
    @break

    @case('OnTheWay')
        @if ($user_role == 3 || $user_role == 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>@endif
        @if (Auth::user()->id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/DeatachReqested">Cancel this Ride</a>@endif
        @if ($user_role >= 3 || $user_role == 4 )<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>@endif
    @break

    @case('Reactived')
        @if ($user_role == 3 || $user_role == 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>@endif
        @if (Auth::user()->id == $rideable->user_id)<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/DeatachReqested">Cancel this Ride</a>@endif
        @if ($user_role >= 3 || $user_role == 4 )<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>@endif
    @break

    @case('DeatachReqested')
        @if ($user_role == 3)
            >> The creator of this ticket asking you to deatach <a class="badge badge-danger" href="/ride/detach/{{$rideable->rides->first()->id}}/{{$rideable->id}}">x</a> driver.
        @endif
    @break

    @case('NotAvailable')
        @if ($user_role == 2 )<a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-active</a>@endif
        @if ($user_role == 2 || $user_role == 3 )<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>@endif
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
{{--
@switch($action)
    @case('On The Way')
        <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>
        <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
        <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/{{($rideable->type=='Delivery')?'Delivered':'Picked-up'}}">{{($rideable->type=='Delivery')?'Deliver':'Pick-up'}}</a>
    @break

    @case('Delivered')
        <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('Picked-up')
        <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('NotAvailable')
        <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
        <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
        @if (Auth::user() && Auth::user()->role_id >= 3 )
            <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
        @endif
    @break

    @case('Canceled')
        @if (Auth::user() && Auth::user()->role_id >= 3 )
            <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
        @endif
        @if (Auth::user() && Auth::user()->role_id >= 4 )
            <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
        @endif
        <a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-active</a>
        <a class="badge badge-success" href="/rideable/{{$rideable->id}}/WaitingForDropOff">Drop off</a>
    @break

    @case('Archived')
        Trip Done
    @break

    @default
        @if (Auth::user() && Auth::user()->role_id >= 3 )
            <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
        @endif
        <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NotAvailable">NON/A</a>
        <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
        <a class="badge badge-success" href="/rideable/{{$rideable->id}}/WaitingForDropOff">Drop off</a>
@endswitch --}}
