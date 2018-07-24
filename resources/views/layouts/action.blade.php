@php
    $user_role = Auth::user() && Auth::user()->role_id;
    $title = 'Done';
    if ($rideable->type=='Delivery')   $title = 'Delivered';
    if($rideable->type=='Pickup')  $title = 'Picked up';
    // if($ridable->location->name='CertiFit')  $title = 'Dropped off';
@endphp
@switch($action)
    @case('Created')
        @if ($user_role = 3 )<a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>@endif
    @break

    @case('On The Way')
        @if ($user_role = 2 || $user_role = 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NON.A">NON/A</a>@endif
        @if ($user_role = 3 || $user_role = 4 )<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>@endif
    @break

    @case('Reactived')
        @if ($user_role = 2 || $user_role = 3 )<a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NON.A">NON/A</a>@endif
        @if ($user_role = 3 || $user_role = 4 )<a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Done">{{$title}}</a>@endif
    @break

    @case('NON.A')
        @if ($user_role = 2 )<a class="badge badge-info" href="/rideable/{{$rideable->id}}/Reactived">Re-active</a>@endif
        @if ($user_role = 2 || $user_role = 3 )<a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>@endif
    @break

    @default
@endswitch
{{--
@switch($action)
    @case('On The Way')
        <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NON.A">NON/A</a>
        <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
        <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/{{($rideable->type=='Delivery')?'Delivered':'Picked-up'}}">{{($rideable->type=='Delivery')?'Deliver':'Pick-up'}}</a>
    @break

    @case('Delivered')
        <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('Picked-up')
        <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('NON.A')
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
        <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NON.A">NON/A</a>
        <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
        <a class="badge badge-success" href="/rideable/{{$rideable->id}}/WaitingForDropOff">Drop off</a>
@endswitch --}}
