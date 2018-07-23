<ul class="list-group" id='ride'>
    <li class="ride list-group-item py-0 list-group-item-secondary">
        <div class="row m-0 p-0">
            <div class="col-4">Created at</div>
            <div class='col-2'>Miles Driven</div>
            <div class='col-2'>Total Trip</div>
        </div>
    </li>
    @foreach ($rides as $key => $ride)
        <li class="list-group-item disabled py-2 active font-weight-bold">{{$ride->fname.' '.$ride->lname}}</li>
        <li class="row m-0 p-0 mb-1 border  border-secondary">
Check rideList.blade.php 
        </li>
    @endforeach
</ul>
