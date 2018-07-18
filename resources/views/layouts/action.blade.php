@switch($action)
    @case('On The Way')
    <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NON.A">NON/A</a>
    <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>

    <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/{{($rideable->type=='Delivery')?'Delivered':'Picked-up'}}">{{($rideable->type=='Delivery')?'Delivered':'Picked-up'}}</a>
    @break

    @case('Delivered')
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('Picked-up')
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('NON.A')
    <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Cancel">Cancel</a>
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @if (Auth::user() && Auth::user()->role_id >= 3 )
        <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
    @endif
    @break

    @case('Canceled')
    @if (Auth::user() && Auth::user()->role_id >= 3 )
        <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
    @endif
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archived">Archive</a>
    @break

    @case('Archived')
    Trip Done
    @break

    @default
    @if (Auth::user() && Auth::user()->role_id >= 3 )
        <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
    @endif
    <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/NON.A">Hold</a>
    <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
@endswitch
