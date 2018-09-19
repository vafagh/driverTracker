<li class="nav-item">
    <a class="nav-link home" href="/" title="Home">
        <i class="material-icons">home</i>
        <span class="d-inline d-sm-none">Home</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link map" href="/map" title="Map">
        <i class="material-icons">map</i>
        <span class="d-inline d-sm-none">Map</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link pickup" href="/pickup" title="Pickups">
        <i class="material-icons d-md-inline d-lg-none">domain</i>
        <span class="d-inline d-sm-none d-md-inline">Pickups</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link deliveries" href="/delivery" title="Deliveries">
        <i class="material-icons d-md-inline d-lg-none">store_mall_directory</i>
        <span class="d-inline d-sm-none d-md-inline">Deliveries</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link drivers" href="/drivers" title="Drivers">
        <i class="material-icons">face</i>
        <span class="d-inline d-sm-none">Drivers</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link trucks" href="/trucks" title="Trucks">
        <i class="material-icons">&#xE558;</i>
        <span class="d-inline d-sm-none">Trucks</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link locations" href="/locations" title="Locations">
        <i class="material-icons">place</i>
        <span class="d-inline d-sm-none">Locations</span>
    </a>
</li>
@if (Auth::user()->role_id>3)
    <li class="nav-item">
        <a class="nav-link rides" href="/rides">
            <i class="material-icons">compare_arrows</i>
            <span class="d-inline d-sm-none">Rides</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link fillups" href="/fillups" title="Fillups">
            <i class="material-icons">local_gas_station</i>
            <span class="d-inline d-sm-none">Fillups</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link users" href="/users" title="Users">
            <i class="material-icons">supervised_user_circle</i>
            <span class="d-inline d-sm-none">Users</span>
        </a>
    </li>
@endif
