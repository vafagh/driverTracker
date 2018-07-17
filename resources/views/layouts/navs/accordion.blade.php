<div id="accordion">
    @php
    $items = ['Pickups','Deliveries','Drivers','Trucks','Clients','Warehouses','Fillups'];
    @endphp

    @foreach ($items as $menuitem)
    <a id='item{{$loop->iteration}}' href="#"
    class="list-group-item list-group-item-action bg-eee"
    data-toggle="collapse"
    data-target="#{{strtolower($menuitem).$loop->iteration}}"
    aria-expanded="true"
    aria-controls="{{strtolower($menuitem).$loop->iteration}}">
    {{$menuitem}}
    </a>

    <div id="{{strtolower($menuitem).$loop->iteration}}" class="collapse" aria-labelledby="item{{$loop->iteration}}" data-parent="#accordion">
        <div class="list-group">
            <a href="/{{strtolower($menuitem)}}" class="list-group-item list-group-item-action">List</a>
            {{-- <a href="/{{strtolower($menuitem)}}/add" class="list-group-item list-group-item-action">Add new</a> --}}
        </div>
    </div>
    @endforeach
</div>
