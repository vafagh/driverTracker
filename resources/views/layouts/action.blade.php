@switch($action)
    @case('On The Way')
        <a class="badge badge-danger" href="#">Cancel</a>
        <a class="badge badge-primary" href="#">Deliverd</a>
        @break

    @case('Delivered')
        <a class="badge badge-warning" href="#">Archive</a>
        @break

    @case('Waiting')
        <a class="badge badge-danger" href="#">Cancel</a>
        <a class="badge badge-success" href="#">Assign</a>
        <a class="badge badge-warning" href="#">Archive</a>
        @break

    @case('Canceled')
        <a class="badge badge-warning" href="#">Archive</a>
        @break

    @default
        <a class="badge badge-danger" href="#">Cancel</a>
        <a class="badge badge-success" href="#">Assign</a>
@endswitch
