<div class="modal-body">
    <div class="form-group row">
        <div class="col-6">
            <label for="license_plate" class="col-form-label">License Plate</label>
            <input name="license_plate" value="{{$object->license_plate}}" class="form-control form-control" type="text" placeholder="" required>
        </div>
        <div class="col-6">
            <label for="gas_card" class="col-form-label">Gas Card</label>
            <input name="gas_card" value="{{$object->gas_card}}" class="form-control form-control" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="tank_capacity" class="col-form-label">Tank Capacity</label>
            <input name="tank_capacity" value="{{$object->tank_capacity}}" class="form-control form-control" type="text" placeholder="Enter the number ">
        </div>
        <div class="col-6">
            <label for="last4vin" class="col-form-label">Vin Number</label>
            <input name="last4vin" value="{{$object->last4vin}}" class="form-control form-control" type="text" placeholder="xxxx">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4">
            <label for="mileage" class="col-form-label">Milage</label>
            <input name="mileage" value="{{$object->mileage}}" class="form-control form-control" type="text" placeholder="Year Make Model">
        </div>
        <div class="col-8">
            <label for="lable" class="col-form-label">Label</label>
            <input name="lable" value="{{$object->lable}}" class="form-control form-control" type="text" placeholder="Year Make Model">
        </div>
    </div>

    <div class="form-row ">
        @if ($object->image!='')

            <label class="file-label" for="image">Update picture</label>
        <div class="row col-2">
            <div class="col-12 ">
                <img class="w-100" src="/img/truck/{{$object->image}}" alt="">
            </div>
        </div>
    @endif
        <div class="col-10 ">
            <input name="image" type="file" class="file-input" id="image">
        </div>
    </div>
</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
