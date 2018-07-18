@switch($action)
    @case('On The Way')
    <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/Holded">Hold</a>
    <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
    <a class="badge badge-primary" href="/rideable/{{$rideable->id}}/Delivered">Deliverd</a>
    @break

    @case('Delivered')
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archive">Archive</a>
    @break

    @case('Holded')
    <a class="badge badge-success" href="/rideable/{{$rideable->id}}/On The Way">Unhold</a>
    <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Cancel">Cancel</a>
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archive">Archive</a>
    @break

    @case('Canceled')
    <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
    <a class="badge badge-dark" href="/rideable/{{$rideable->id}}/Archive">Archive</a>
    @break

    @default
    <a class="badge badge-success" href="/ride/create/{{$rideable->id}}/">Assign</a>
    <a class="badge badge-warning" href="/rideable/{{$rideable->id}}/Holded">Hold</a>
    <a class="badge badge-danger" href="/rideable/{{$rideable->id}}/Canceled">Cancel</a>
@endswitch
