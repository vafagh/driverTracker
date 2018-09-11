<div class="modal-body">
    @php
    $drivers = App\Driver::where('truck_id','!=','')->orderBy('fname')->get();
    @endphp
    {{$drivers->count()}} driver with truck found.
    <div class="form-group">
        <label for="driver" class="col-form-label">Driver:</label>
        <select class="form-control form-control-lg" name="driver">
            @foreach ( $drivers as $driver)
                <option value="{{$driver->id}}">{{$driver->fname}} -> {{App\Truck::find($driver->truck_id)->lable}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <input name="distance" type="hidden" value="{{$object->location->distance}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary">Assign</button>
</div>
