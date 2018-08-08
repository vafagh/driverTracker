<div class="modal-body">
    <div class="form-group row">
        <div class="col-6">
            <label for="license_plate" class="col-form-label">License Plate</label>
            <input name="license_plate" class="form-control form-control-sm" type="text" placeholder="" required>
        </div>
        <div class="col-6">
            <label for="gas_card" class="col-form-label">Gas Card</label>
            <input name="gas_card" class="form-control form-control-sm" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="tank_capacity" class="col-form-label">Tank Capacity</label>
            <input name="tank_capacity" class="form-control form-control-sm" type="text" placeholder="Enter the number ">
        </div>
        <div class="col-6">
            <label for="last4vin" class="col-form-label">Vin Number</label>
            <input name="last4vin" class="form-control form-control-sm" type="text" placeholder="xxxx">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-4">
            <label for="mileage" class="col-form-label">Mileage</label>
            <input name="mileage" class="form-control form-control-sm" type="text" placeholder="Enter Vehicle milage" required>
        </div>
        <div class="col-8">
            <label for="lable" class="col-form-label">Label</label>
            <input name="lable" class="form-control form-control-sm" type="text" placeholder="Year Make Model">
        </div>
    </div>

    <div class="custom-file">
        <input name="image" type="file" class="custom-file-input" id="image">
        <label class="custom-file-label" for="image">Choose picture</label>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
