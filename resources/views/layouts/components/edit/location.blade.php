<div class="modal-body">
    <div class="form-group">
        <label for="name" class="col-form-label">Location Name</label>
        <input name="name" class="form-control form-control" type="text" value="{{$object->name}}" required>
    </div>

    <div class="form-group">
        <label for="person" class="col-form-label">Contact Person</label>
        <input name="person" class="form-control form-control" type="text" value="{{$object->person}}" required>
    </div>

    <div class="form-group">
        <label for="phone" class="col-form-label">Phone</label>
        <input name="phone" class="form-control form-control" type="text" value="{{$object->phone}}" required>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="type" class="col-form-label">Type:</label>
            <select class="form-control form-control-lg" name="type">
                <option {{($object->type == 'Client') ? 'selected' : ''}} value="Client">Client</option>
                <option {{($object->type == 'Warehouse') ? 'selected' : ''}} value="Warehouse">Warehouse - pickup</option>
                <option {{($object->type == 'DropOff') ? 'selected' : ''}} value="DropOff">Warehouse - drop off</option>
            </select>
        </div>
        <div class="col-6 row">
            <label for="distance" class="col-form-label">Distance from Eagle</label>
            <div class="col-8 p-0">
                <input name="distance" class="form-control form-control" type="text" value="{{$object->distance}}">
            </div>
            <div class="col-4 p-0">
                mile
            </div>
        </div>
    </div>


    <div class="form-group">
        <label for="line1" class="col-form-label">Address</label>
        <input name="line1" class="mt-1 form-control form-control" type="text" placeholder="Line 1" value="{{$object->line1}}">
        <input name="line2" class="mt-1 form-control form-control" type="text" placeholder="Line 2" value="{{$object->line2}}">
        <div class="row m-0 p-0">
            <input name="city" class="mt-1 col-4 form-control form-control" type="text" placeholder="City" value="{{$object->city}}">
            <input name="state" class="mt-1 col-4 form-control form-control" type="text" placeholder="State" value="{{$object->state}}">
            <input name="zip" class="mt-1 col-4 form-control form-control" type="text" placeholder="Zip Code" value="{{$object->zip}}">
        </div>
    </div>

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
