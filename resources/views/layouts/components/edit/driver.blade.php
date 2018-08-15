<div class="modal-body">
    <div class="form-group">
        <label for="fname" class="col-form-label">First Name</label>
        <input name="fname" class="form-control form-control" type="text" value="{{$object->fname}}" required>
    </div>
    <div class="form-group">
        <label for="lname" class="col-form-label">Last Name</label>
        <input name="lname" class="form-control form-control" type="text" value="{{$object->lname}}" required>
    </div>
    <div class="form-group">
        <label for="phone" class="col-form-label">Phone number</label>
        <input name="phone" class="form-control form-control" type="text" value="{{$object->phone}}">
    </div>
    <div class="form-group">
        <label for="email" class="col-form-label">Email Address</label>
        <input name="email" class="form-control form-control" type="text" value="{{$object->email}}">
    </div>
    <div class="form-group select">
        <label for="truck" class="col-form-label">Driving:</label>
        @php
        $availableTrucks = App\Truck::whereNotIn('id',App\Driver::where('truck_id','!=',NULL)->get()->pluck('truck_id')->toArray());
        @endphp
        @if ($availableTrucks->count()>0)
            <select class="form-control form-control locations" name="truck" required>
                @if (!empty($object->truck_id))
                    <option value='clear'>{{App\Truck::find($object->truck_id)->license_plate}}</option>
                @else
                    <option value='clear'></option>
                @endif
                @foreach ($availableTrucks->orderBy('lable')->get() as $truck)
                    <option {{($truck->id==$object->truck_id) ? 'selected':''}} value="{{$truck->id}}">
                        ({{$truck->id.'):'.$truck->label.' LP:'.$truck->license_plate.' VIN:'.$truck->last4vin}}
                    </option>
                @endforeach
            </select>
        @else
            <div class="">
                All truck is occupaited by drivers.
                <div class="text-muted">
                    To assign a truck to this driver: first you have to un-assign the target truck from current driver.
                </div>
            </div>
        @endif
    </div>
    <div class="form-row ">
        <div class="row col-2">
            <div class="col-12 ">
                <img class="w-100" src="/img/driver/{{$object->image}}" alt="">
            </div>
        </div>
        <div class="col-10 ">
            <input name="avatar" type="file" class="custom-file-input">
            <label class="custom-file-label" for="avatar">Update picture</label>
        </div>
    </div>

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
