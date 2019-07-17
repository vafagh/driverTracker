@php
    $direction = (empty($trigger)) ? '' : 'dropup' ;
@endphp

<li class="nav-item">
    <a class="nav-link home" href="/" title="Home">
        <i class="material-icons">home</i>
        <span class="d-inline d-md-none">Home</span>
    </a>
</li>
<li class="nav-item dropdown {{$direction}}">
    <a id="mapDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
        <span>
            <i class="material-icons">map</i>
        </span>
        <span class="d-inline d-md-none">Map</span>
    </a>
    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="mapDropdown">
        <a class="nav-link map" href="/map?delivery_date=all">All</a>
        <a class="nav-link map" href="/map?shift=Morning&amp;delivery_date={{\Carbon\Carbon::yesterday()->toDateString()}}">Yesterday 1st</a>
        <a class="nav-link map" href="/map?shift=Evening&amp;delivery_date={{\Carbon\Carbon::yesterday()->toDateString()}}">Yesterday 2nd</a>
        <a class="nav-link map" href="/map?shift=Morning&amp;delivery_date={{\Carbon\Carbon::today()->toDateString()}}">Today 1st</a>
        <a class="nav-link map" href="/map?shift=Evening&amp;delivery_date={{\Carbon\Carbon::today()->toDateString()}}">Today 2nd</a>
        <a class="nav-link map" href="/map?shift=Morning&amp;delivery_date={{\Carbon\Carbon::tomorrow()->toDateString()}}">Tomorrow 1st</a>
        <a class="nav-link map" href="/map?shift=Evening&amp;delivery_date={{\Carbon\Carbon::tomorrow()->toDateString()}}">Tomorrow 2nd</a>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link pickup" href="/pickup" title="Pickups">
        <i class="material-icons d-md-inline d-lg-none  d-xl-inline">domain</i>
        <span class="d-inline d-md-none d-md-none d-lg-inline">Pickups</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link deliveries" href="/delivery" title="Deliveries">
        <i class="material-icons d-md-inline d-lg-none  d-xl-inline">store_mall_directory</i>
        <span class="d-inline d-md-none d-md-none d-lg-inline">Deliveries</span>
    </a>
</li>
<li class="nav-item dropdown {{$direction}}">
    <a id="driverDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
        <i class="material-icons d-xl-none ">face</i>
        <span class="d-inline d-md-none d-xl-inline mi   ">Drivers</span>
    </a>

    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="driverDropdown">
        @foreach ($activeDrivers as $key => $driver)
            <a class="nav-link drivers row m-0 p-0" href="/driver/show/{{$driver->id}}" title="Drivers">
                <span class="pr-2"> </span>
                <img class="rounded-circle minh-40 align-" alt="{{$driver->fname}}" src="/img/driver/{{($driver->image == null) ? 'def.svg' : $driver->image }}">
                <span class="">{{$driver->fname}}</span>
            </a>
        @endforeach
        <a class="nav-link drivers" href="/drivers" title="Drivers">
            <span class="">All Drivers</span>
        </a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link trucks" href="/trucks" title="Trucks">
        <i class="material-icons">&#xE558;</i>
        <span class="d-inline d-md-none">Trucks</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link locations" href="/locations" title="Locations">
        <i class="material-icons">place</i>
        <span class="d-inline d-xl-none">Locations</span>
    </a>
</li>
@if (Auth::user()->role_id>3)
    <li class="nav-item">
        <a class="nav-link rides" href="/rides">
            <i class="material-icons">compare_arrows</i>
            <span class="d-inline d-md-none">Rides</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link fillups" href="/fillups" title="Fillups">
            <i class="material-icons">local_gas_station</i>
            <span class="d-inline d-md-none">Fillups</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link fillups" href="/services" title="Service">
            <i class="material-icons">build</i>
            <span class="d-inline d-md-none">Service</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link users" href="/users" title="Users">
            <i class="material-icons">supervised_user_circle</i>
            <span class="d-inline d-md-none">Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="material-icons">power_settings_new</i>
            <span class="d-inline d-md-none">Logout</span>
        </a>
    </li>
@endif
