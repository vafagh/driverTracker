<div class="modal-body">
    <div class="form-group">
        <label for="rideable_id" class="col-form-label">To: <strong>{{$object->location->name}}</strong></label>
        <input name="id" type="hidden" value="{{$object->id}}" required>
        <input name="distance" type="hidden" value="{{$object->location->distance}}" required>
    </div>

    <div class="row">
        <div class="form-group col-12 col-sm-6">
            <label for="driver-name" class="col-form-label">Driver:</label>
            <select class="form-control form-control-lg" name="driver" required>
                <option value=""></option>
                @foreach (App\Driver::all() as $driver)
                    <option value="{{$driver->id}}">{{$driver->fname.', '.$driver->lname}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group  col-12 col-sm-6">
            <label for="truck-name" class="col-form-label">Truck:</label>
            <select class="form-control form-control-lg" name="truck" required>
                <option value=""></option>
                @foreach (App\Truck::all() as $truck)
                    <option class="fixedWidthFont" value="{{$truck->id}}">
                        {{$truck->license_plate}}
                        <span class='bg-222'>VIN:{{$truck->last4vin}}</span> _
                        {{$truck->lable}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <input name="distance" type="hidden" value="{{$object->location->distance}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Assign</button>
</div>
