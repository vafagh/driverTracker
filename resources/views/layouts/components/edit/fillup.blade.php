<div class="modal-body">

    <div class="form-group">
        <label for="fname" class="col-form-label">
            Driver: @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$object->driver])@endcomponent
            </label>
        </div>
        <div class="form-group">
            <label for="fname" class="col-form-label">
                Truck:  @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$object->truck])@endcomponent
                </label>
            </div>
            <div class="form-group row ">
                <div class="col-6">
                    <label for="gas_card" class="col-form-label">Gas Card</label>
                    <input name="gas_card" class="form-control form-control-sm" type="text" value="{{$object->gas_card}}" required>
                </div>
                <div class="col-3">
                    <label for="gallons" class="col-form-label">Gallons</label>
                    <input name="gallons" class="form-control form-control-sm" type="text" value="{{$object->gallons}}" required>
                </div>
                <div class="col-3">
                    <label for="product" class="col-form-label">Product</label>
                    <select class="form-control form-control-lg" name="product">
                        <option {{($object->product == 'E85') ? 'selected' : ''}} value="Client">E85</option>
                        <option {{($object->product == 'Regular') ? 'selected' : ''}} value="Warehouse">Regular</option>
                        <option {{($object->product == 'Midgrade') ? 'selected' : ''}} value="Warehouse">Midgrade</option>
                        <option {{($object->product == 'Premium') ? 'selected' : ''}} value="Warehouse">Premium</option>
                        <option {{($object->product == 'Diesel') ? 'selected' : ''}} value="Warehouse">Diesel</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-4">
                    <label for="price_per_gallon" class="col-form-label">Price Per Gallon</label>
                    <input name="price_per_gallon" class="form-control form-control-sm" type="text" value="{{$object->price_per_gallon}}" required>
                </div>
                <div class="col-4">
                    <label for="total" class="col-form-label">Total</label>
                    <input name="total" class="form-control form-control-sm" type="text" value="{{$object->total}}" required>
                </div>
                <div class="col-4">
                    <label for="mileage" class="col-form-label">Mileage</label>
                    <input name="mileage" class="form-control form-control-sm" type="text" value="{{$object->mileage}}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="gallons" class="col-form-label">{{$object->created_at}}</label>
            </div>

            <div class="custom-file">
                <input name="image" type="file" class="custom-file-input" id="image">
                <label class="custom-file-label" for="customFile">Update picture</label>
            </div>

        </div>
        <div class="modal-footer">
            <input name="id" type="hidden" value="{{$object->id}}">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
