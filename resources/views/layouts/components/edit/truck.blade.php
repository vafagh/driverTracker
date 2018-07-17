<div class="modal-body">
    <div class="form-group">
        <label for="license_plate" class="col-form-label">License Plate</label>
        <input name="license_plate" value="{{$object->license_plate}}" class="form-control form-control-sm" type="text" placeholder="" required>
    </div>
    <div class="form-group">
        <label for="gas_card" class="col-form-label">Gas Card</label>
        <input name="gas_card" value="{{$object->gas_card}}" class="form-control form-control-sm" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" required>
    </div>
    <div class="form-group">
        <label for="tank_capacity" class="col-form-label">Tank Capacity</label>
        <input name="tank_capacity" value="{{$object->tank_capacity}}" class="form-control form-control-sm" type="text" placeholder="Enter the number ">
    </div>
    <div class="form-group">
        <label for="last4vin" class="col-form-label">Vin Number</label>
        <input name="last4vin" value="{{$object->last4vin}}" class="form-control form-control-sm" type="text" placeholder="xxxx">
    </div>
    <div class="form-group">
        <label for="lable" class="col-form-label">Lable</label>
        <input name="lable" value="{{$object->lable}}" class="form-control form-control-sm" type="text" placeholder="Year Make Model">
    </div>
    <div class="custom-file">
        <input name="image" value="{{$object->image}}" type="file" class="custom-file-input" id="image">
        <label class="custom-file-label" for="image">Choose picture</label>
    </div>

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
