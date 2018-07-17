<div class="modal-body">
    <div class="form-group">
        <label for="rideable_id" class="col-form-label">To: <strong>{{$object->location->name}}</strong></label>
        <br>
        <strong>{{$object->id}}</strong>
        <input name="idid" type="hidden" value="{{$object->id}}" required>
        <input name="distance" type="hidden" value="{{$object->location->distance}}" required>
    </div>
    <div class="form-group">
      <label for="driver-name" class="col-form-label">Driver:</label>
      <select class="form-control form-control-lg" name="driver">
          @foreach (App\Driver::all() as $driver)
              <option value="{{$driver->id}}">{{$driver->fname.', '.$driver->lname}}</option>
          @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="truck-name" class="col-form-label">Truck:</label>
      <select class="form-control form-control-lg" name="truck">
          @foreach (App\Truck::all() as $truck)
              <option value="{{$truck->id}}">{{$truck->lable.' '.$truck->license_plate.', '.$truck->last4vin}}</option>
          @endforeach
      </select>
    </div>


</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Assign</button>
</div>
