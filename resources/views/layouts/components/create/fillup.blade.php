<div class="modal-body">


    <div class="form-group">
        <label for="driver-name" class="col-form-label">Driver:</label>
        <select class="form-control form-control-lg" name="driver_id">
            @foreach (App\Driver::all() as $driver)
                <option value="{{$driver->id}}">{{$driver->fname.', '.$driver->lname}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="truck-name" class="col-form-label">Truck:</label>
        <select class="form-control form-control-lg" name="truck_id">
            @foreach (App\Truck::all() as $truck)
                <option value="{{$truck->id}}">{{$truck->lable.' '.$truck->license_plate.', '.$truck->last4vin}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group row ">
        <div class="col-6">
            <label for="gas_card" class="col-form-label">Gas Card</label>
            <input name="gas_card" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-3">
            <label for="gallons" class="col-form-label">Gallons</label>
            <input name="gallons" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-3">
            <label for="product" class="col-form-label">Product</label>
            <select class="form-control form-control-lg" name="product">
                <option value="Client">E85</option>
                <option selected value="Warehouse">Regular</option>
                <option value="Warehouse">Midgrade</option>
                <option value="Warehouse">Premium</option>
                <option value="Warehouse">Diesel</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-4">
            <label for="price_per_gallon" class="col-form-label">Price Per Gallon</label>
            <input name="price_per_gallon" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-4">
            <label for="total" class="col-form-label">Total</label>
            <input name="total" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-4">
            <label for="mileage" class="col-form-label">Mileage</label>
            <input name="mileage" class="form-control form-control-sm" type="text" required>
        </div>
    </div>

    <div class="form-group">
        <label for="gallons" class="col-form-label"></label>
    </div>

    <div class="custom-file">
        <input name="image" type="file" class="custom-file-input" id="image">
        <label class="custom-file-label" for="customFile">Update picture</label>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
