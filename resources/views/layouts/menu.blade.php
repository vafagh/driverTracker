@php
    $direction = (empty($trigger)) ? '' : 'dropup' ;
@endphp

<li class="nav-item">
    <a class="nav-link home" href="/" title="Home">
        <i class="material-icons">home</i>
        <span class="d-inline d-md-none">Home</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link home" href="/backorder" title="Backorders">
        <i class="material-icons">pending</i>
        <span class="d-inline d-md-none d-lg-inline">Backorder</span>
    </a>
</li>


<li class="nav-item dropdown {{$direction}}">
    <a id="driverDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
        <i class="material-icons d--none ">map</i>
        <span class="d-inline d-md-none">Maps</span>
    </a>
    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="driverDropdown">
        <a title="Morning shift" class="nav-link map" href="/map?shift=Morning&amp;delivery_date={{\Carbon\Carbon::today()->toDateString()}}">
            <i class="material-icons  text-success">map</i>
            <span class="d-inline">Morning Map</span>
        </a>
        <a title="Evening shift" class="nav-link map" href="/map?shift=Evening&amp;delivery_date={{\Carbon\Carbon::today()->toDateString()}}">
            <i class="material-icons  text-warning">map</i>
            <span class="d-inline">Evening Map</span>
        </a>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link pickup" href="/pull" title="pull">
        <i class="material-icons d-md-inline   d-xl-inline">doorbell</i>
        <span class="d-inline d-md-none ">Pull</span>
    </a>
</li>
{{-- <li class="nav-item">
    <a class="nav-link pickup" href="/status" title="Current Shift Driver Tickets">
        <i class="material-icons d-md-inline d-lg  d-xl-inline">list</i>
        <span class="d-inline d-md-none ">BO</span>
    </a>
</li> --}}
<li class="nav-item">
    <a class="nav-link deliveries" href="/delivery" title="Deliveries">
        <i class="material-icons d-md-inline d-lg  d-xl-inline">schedule_send</i>
        <span class="d-inline d-md-none d-md-none d-lg-inline">Delivery</span>
    </a>
</li>
<li class="nav-item dropdown {{$direction}}">
    <a id="driverDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
        <i class="material-icons d--none ">person</i>
        <span class="d-inline d-md-none d-lg-inline">Drivers</span>
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
        <span class="d-inline d-md-none">Garage</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link locations" href="/locations" title="Locations">
        <i class="material-icons">place</i>
        <span class="d-inline d-md-none">Locations</span>
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
