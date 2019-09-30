<div class="modal-body">

    <div class="form-group row">
        <div class="col-6">
            <label for="fname{{$object->id}}" class="col-form-label">First Name</label>
            <input id="fname{{$object->id}}" name="fname" class="form-control" type="text" value="{{$object->fname}}" required>
        </div>
        <div class="col-6">
            <label for="lname{{$object->id}}" class="col-form-label">Last Name</label>
            <input id="lname{{$object->id}}" name="lname" class="form-control" type="text" value="{{$object->lname}}" required>
        </div>
    </div>

    <div class="form-group">
        <label for="email{{$object->id}}" class="col-form-label">Email Address</label>
        <input id="email{{$object->id}}" name="email" class="form-control" type="text" value="{{$object->email}}">
    </div>

    <div class="form-group">
        <label for="phone{{$object->id}}" class="col-form-label">Phone number</label>
        <input id="phone{{$object->id}}" name="phone" class="form-control" type="text" value="{{$object->phone}}">
    </div>

    <div class="form-group row">
        <div class=" col-6">
            <label for="color{{$object->id}}" class="col-form-label">Map Marker Color:</label>
            <select class="form-control locations" name="color" id="color{{$object->id}}" required>
                <option value>Select one</option>

                @foreach (['black','brown','green','purple','blue','gray','orange','red','0xffccff','yellow','white'] as $value)
                    <option style='color:{{substr($value,1,1)=='x' ? '#'.substr($value,2):$value}}' {{($value==$object->color) ? 'selected' : ''}} value="{{ $value }}">{{ ucfirst($value) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <div class="col-form-label">Status</div>
            <input class="form-check-input pl-2" type="checkbox" {{($object->working)?'checked':''}} id="working{{$object->id}}"  name="working" >
            <label for="working{{$object->id}}">Eagle Employee</label>
        </div>
    </div>

    <div class="form-group select">
        <label for="truck{{$object->id}}" class="col-form-label">Driving:</label>
        @php
        $availableTrucks = App\Truck::whereNotIn('id',App\Driver::where('truck_id','!=',NULL)->get()->pluck('truck_id')->toArray());
        @endphp
        <select class="form-control locations" id='truck{{$object->id}}' name="truck">
            @if (empty($object->truck_id))
                <option selected value="">Not Driving</option>
            @else
                <option selected value='{{$object->truck_id}}'>{{App\Truck::find($object->truck_id)->license_plate}}</option>
            @endif
            @foreach ($availableTrucks->orderBy('lable')->get() as $truck)
                <option {{($object->id==$truck->truck_id) ? 'selected':''}} value="{{$truck->id}}">
                    ({{$truck->id.'):'.$truck->lable.' LP:'.$truck->license_plate.' VIN:'.$truck->last4vin}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-row ">
        <div class="row col-2">
            <div class="col-12 ">
                <img class="w-100" src="/img/driver/{{$object->image}}" alt="">
            </div>
        </div>
        <div class="col-10 ">
            <input id="avatar{{$object->id}}" name="avatar" type="file" class="custom-file-input">
            <label class="custom-file-label" for="avatar{{$object->id}}">Update picture</label>
        </div>
    </div>

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
