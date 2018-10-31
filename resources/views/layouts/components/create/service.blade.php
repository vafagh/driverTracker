<div class="modal-body">


    <div class="form-group">
        <label for="driver-name" class="col-form-label">Service Date:</label>
        <input name="created_at" class="form-control d-inline w-75" type="date">
    </div>
    <div class="form-group">
        <label for="driver-name" class="col-form-label">Driver:</label>
        <select class="form-control form-control-lg" name="driver_id">
            @foreach (App\Driver::all() as $driver)
                <option value="{{$driver->id}}">{{$driver->fname.', '.$driver->lname}}</option>
            @endforeach
            <option value="0">Not applicable</option>
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

        <div class="col-12">
            <label for="product" class="col-form-label">Service type</label>
            <select class="form-control form-control-lg" name="product">
                <option value="oil">Oil change</option>
                <option selected value="tirefix">Tire fix</option>
                <option value="tire">New tire</option>
                <option value="engine">Mechanic Engine</option>
                <option value="suspension">Mechanic Suspension</option>
                <option value="body">Body work</option>
                <option value="other">Other</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="message-text" class="col-form-label">Service details:</label>
        <textarea class="form-control" name="description" placeholder="type in aboute the service and resoan for getting it" required></textarea>
    </div>

    <div class="form-group row">
        <div class="col-4">
            <label for="mileage" class="col-form-label">Service Mileage</label>
            <input name="mileage" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-auto">
            <label class="" for="total">Total charge</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                </div>
                <input type="text" class="form-control" id="total" name="total" placeholder="0.00" required>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-6">
            <label for="shop" class="col-form-label">Shop Name</label>
            <input name="shop" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-6">
            <label for="shop_phone" class="col-form-label">Shop phone</label>
            <input name="shop_phone" class="form-control form-control-sm" type="phone" >
        </div>
    </div>
    <div class="custom-file">
        <input name="image" type="file" class="custom-file-input" id="image">
        <label class="custom-file-label" for="customFile">Update picture</label>
    </div>

    <fieldset>
        <hr>
        <h5>
            Billing
        </h5>
        <div class="form-group row">
            <div class="col-12">
                <label for="voucher_number" class="col-form-label">Eagle Voucher Number</label>
                <input name="voucher_number" class="form-control form-control-sm" type="number">
            </div>
        </div>
    </fieldset>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
