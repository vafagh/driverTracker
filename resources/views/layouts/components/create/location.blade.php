<div class="modal-body">
    <div class="form-group">
        <label for="name" class="col-form-label">Location Name</label>
        <input name="name" class="form-control form-control" type="text" required>
    </div>

    <div class="form-group">
        <label for="person" class="col-form-label">Contact Person</label>
        <input name="person" class="form-control form-control" type="text" required>
    </div>

    <div class="form-group">
        <label for="phone" class="col-form-label">Phone</label>
        <input name="phone" class="form-control form-control" type="text"  required>
    </div>

    <div class="form-group row">
        <div class="col-6">
            <label for="type" class="col-form-label">Type:</label>
            <select class="form-control form-control-lg" name="type">
                <option value="Client">Client</option>
                <option value="Warehouse">Warehouse</option>
            </select>
        </div>
        <div class="col-6 row">
            <label for="distance" class="col-form-label">Distance from Eagle</label>
            <div class="col-8 p-0">
                <input name="distance" class="form-control form-control" type="text">
            </div>
            <div class="col-4 p-0">
                mile
            </div>
        </div>
    </div>


    <div class="form-group">
        <label for="line1" class="col-form-label">Address</label>
        <input name="line1" class="mt-1 form-control form-control" type="text" placeholder="Line 1">
        <input name="line2" class="mt-1 form-control form-control" type="text" placeholder="Line 2">
        <div class="row m-0 p-0">
            <input name="city" class="mt-1 col-4 form-control form-control" type="text" placeholder="City">
            <input name="state" class="mt-1 col-4 form-control form-control" type="text" placeholder="State">
            <input name="zip" class="mt-1 col-4 form-control form-control" type="text" placeholder="Zip Code">
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
