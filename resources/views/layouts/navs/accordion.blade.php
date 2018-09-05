<a class="p-2" href="/">Home</a>
<a class="p-2" href="/pickup">Pickups</a>
<a class="p-2" href="/delivery">Deliveries</a>
<a class="p-2" href="/drivers">Drivers</a>
<a class="p-2" href="/trucks">Trucks</a>
<a class="p-2" href="/locations">Locations</a>
@if (Auth::user()->role_id>3)
    <a class="p-2" href="/rides">Rides</a>
    <a class="p-2" href="/fillups">Fillups</a>
    <a class="p-2" href="/users">Users</a>
@endif
<div class="nav-link">
    &#x276F; <span class="text-info fixedWidthFont h4">
        <span id="countdown"></span>"
    </span>
</div>
