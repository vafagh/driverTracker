<div class="modal-body">
    <div class="form-group">
        <label for="fname" class="col-form-label">First Name</label>
        <input name="fname" class="form-control form-control-sm" type="text" placeholder="Drivers first name" required>
    </div>
    <div class="form-group">
        <label for="fname" class="col-form-label">Last Name</label>
        <input name="lname" class="form-control form-control-sm" type="text" placeholder="Drivers Last name" required>
    </div>
    <div class="form-group">
        <label for="fname" class="col-form-label">Phone number</label>
        <input name="phone" class="form-control form-control-sm" type="text" placeholder="###-###-####">
    </div>
    <div class="form-group">
        <label for="fname" class="col-form-label">Email Address</label>
        <input name="email" class="form-control form-control-sm" type="text" placeholder="example@eagleautobody.com">
    </div>

    <div class="form-group select">
        <label for="truck" class="col-form-label">Driving:</label>
        <select class="form-control form-control-lg locations" name="truck" required>
                <option value='clear'>Null</option>
            @foreach (App\Truck::whereNotIn('id',App\Driver::where('truck_id','!=',NULL)->get()->pluck('truck_id')->toArray())->orderBy('lable')->get() as $truck)
                <option value="{{$truck->id}}">
                    {{$truck->label.' LP:'.$truck->license_plate.' VIN:'.$truck->last4vin}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="custom-file">
        <input name="avatar" type="file" class="custom-file-input" id="avatar">
        <label class="custom-file-label" for="customFile">Choose picture</label>
    </div>
    {{-- <div class="form-group">
        <label for="message-text" class="col-form-label">Note:</label>
        <textarea name="note" class="form-control" id="message-text"></textarea>
    </div> --}}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
