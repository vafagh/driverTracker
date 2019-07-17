<div class="modal-body">
    <div class="form-group row">
        <div class="col-6">
            <label for="fname" class="col-form-label">First Name</label>
            <input id="fname" name="fname" class="form-control" type="text" value="{{$object->fname}}" required>
        </div>
        <div class="col-6">
            <label for="lname" class="col-form-label">Last Name</label>
            <input id="lname" name="lname" class="form-control" type="text" value="{{$object->lname}}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="col-form-label">Phone number</label>
        <input id="phone" name="phone" class="form-control" type="text" value="{{$object->phone}}">
    </div>
    <div class="form-group row">
        <div class="col-6">
            <label for="email" class="col-form-label">Email Address</label>
            <input id="email" name="email" class="form-control" type="text" value="{{$object->email}}">
        </div>
        <div class="col-6">
            <div class="col-form-label">Status</div>
            <input class="form-check-input pl-2" type="checkbox" {{($object->working)?'checked':''}} id="working"  name="working" >
            <label for="working">Eagle Employee</label>
        </div>

    </div>
    <div class="form-group select">
        <label for="truck" class="col-form-label">Driving:</label>
        @php
            $availableTrucks = App\Truck::whereNotIn('id',App\Driver::where('truck_id','!=',NULL)->get()->pluck('truck_id')->toArray());
        @endphp
        {{-- @if ($availableTrucks->count()>0) --}}
            <select class="form-control locations" id='truck' name="truck" required>
                <option {{($object->truck_id=='') ? 'selected':''}} value="">Not Driving</option>
                @if (!empty($object->truck_id))
                    <option value='{{$object->truck_id}}'>{{App\Truck::find($object->truck_id)->license_plate}}</option>
                @endif
                @foreach ($availableTrucks->orderBy('lable')->get() as $truck)
                    <option {{($object->id==$truck->truck_id) ? 'selected':''}} value="{{$truck->id}}">
                        ({{$truck->id.'):'.$truck->lable.' LP:'.$truck->license_plate.' VIN:'.$truck->last4vin}}
                    </option>
                @endforeach
            </select>
        {{-- @else
            <div class="">
                All truck is occupaited by drivers.
                <div class="text-muted">
                    To assign a truck to this driver: first you have to un-assign the target truck from current driver.
                </div>
            </div>
        @endif --}}
    </div>
    <div class="form-row ">
        <div class="row col-2">
            <div class="col-12 ">
                <img class="w-100" src="/img/driver/{{$object->image}}" alt="">
            </div>
        </div>
        <div class="col-10 ">
            <input id="avatar" name="avatar" type="file" class="custom-file-input">
            <label class="custom-file-label" for="avatar">Update picture</label>
        </div>
    </div>

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
