<a class="p-3" href="/">Home</a>
{{-- <a class="p-3" href="/pickups">Pickups</a>
<a class="p-3" href="/deliveries">Deliveries</a> --}}
<a class="p-3" href="/drivers">Drivers</a>
<a class="p-3" href="/trucks">Trucks</a>
<a class="p-3" href="/locations">Locations</a>
@if (Auth::user()->role_id>2)
    <a class="p-3" href="/rides">Rides</a>
    <a class="p-3" href="/fillups">Fillups</a>
@endif
@if (Auth::user()->role_id>3)
    <a class="p-3" href="/users">Users</a>
@endif
<div class="p-3">
    Refresh in <div class="text-info fixedWidthFont d-inline h4">
        <span id="countdown"></span>"
    </div>
</div>
