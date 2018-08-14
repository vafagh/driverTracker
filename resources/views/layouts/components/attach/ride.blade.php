{{-- <div class="modal-body">
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
</div> --}}
<div class="modal-body">
    <div class="form-group">
        <label class="col-form-label">ID : {{$object->id}}</label>
    </div>

    @if ($object->rideable!=null)
    <div class="form-group">
            <label for="location" class="col-form-label">
                {{$object->rideable->type}} for {{$object->rideable->location->name}}
            </label>
        <p>
            Note: {{$object->rideable->description}}
        </p>
        <p>Status: <span class="text-success">{{$object->rideable->status}}</span></p>
    </div>
    @endif

    <div class="form-group">
        <label for="driver" class="col-form-label">Driver:</label>
        <select class="form-control form-control-lg" name="driver">
            @foreach (App\Driver::all() as $driver)
                <option {{($object->driver->id == $driver->id) ? 'selected' : ''}} value="{{$driver->id}}">{{$driver->fname}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="truck" class="col-form-label">Truck:</label>
        <select disabled class="form-control form-control-lg" name="truck">
            @foreach (App\Truck::all() as $truck)
                <option {{($object->truck->id == $truck->id) ? 'selected' : ''}} value="{{$truck->id}}">{{$truck->license_plate}}</option>
            @endforeach
        </select>
    </div>


</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary">Assign</button>
</div>
