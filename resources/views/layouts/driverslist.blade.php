<li class="list-group-item disabled py-2 active font-weight-bold">{{$driver->fname.' '.$driver->lname}}</li>
<li class="row m-0 p-0 mb-1 border  border-secondary">
    <div class="col-1 bg-danger">
        <img class="w-100 pt-4" src="{{($driver->image == null) ? '/img/def.svg' : $driver->image }}" alt="">
    </div>
    <div class="col-11">
        <div class="row mx-0  pt-2">
            <div class="col-3">
                {{$driver->fname.' '.$driver->lname}}
            </div>
            <div  class="col-5">
                {{$driver->created_at}}
            </div>
            <div  class="col-2">
                <h2 class="mb-0">   {{App\Ride::where('driver_id', $driver->id)->sum('distance')}} </h2>Mile
            </div>
            <div  class="col-2">
                <h2 class="mb-0">              {{ App\Ride::where('driver_id', $driver->id)->count() }} </h2>Trip
            </div>
        </div>
        <div class="row m-0  pb-2">
            <div class="col-5 ">
                {{$driver->phone}}
            </div>
            <div class="col-7 text-right  pt-2">
                <a class="btn btn-danger btn-sm mb-1" href="edit">Edit</a>
                <a class="btn btn-success btn-sm mb-1" href="assign">Assign a Ride</a>
                <a class="btn btn-primary btn-sm mb-1" href="/fillups/driver/{{$driver->id}}">Fillups</a>
                <a class="btn btn-secondary btn-sm mb-1" href="/ridables/driver/{{$driver->id}}">Ride History</a>
                <a class="btn btn-warning btn-sm mb-1" href="/truck/driver/{{$driver->id}}">Driving History</a>
            </div>
        </div>
    </div>

</li>
