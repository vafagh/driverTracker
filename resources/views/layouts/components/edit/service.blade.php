<div class="modal-body">
    <div class="form-group">
        <h5>Billing</h5>
        <div class="form-group row">
            <label for="voucher_number" class="col-form-label w-50">Eagle Voucher Number</label>
            <input name="voucher_number" value="{{$object->voucher_number}}" class="form-control form-control-sm d-inline w-50" type="number">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="created_at" class="col-form-label">Service Date:</label>
        <input name="created_at" class="form-control d-inline w-75" type="text" value="{{$object->created_at}}">
    </div>
    <div class="form-group">
        @if (Auth::user()->role_id > 3)
            <select class="form-control form-control-lg" name="driver_id">
                @foreach ($activeDrivers as $driver)
                    <option name="driver_id" value="{{$driver->id}}" {{($object->driver->id == $driver->id)? 'selected':''}}>{{$driver->fname.', '.$driver->lname}}</option>
                @endforeach
            </select>
        @else
            <label for="fname" class="col-form-label">
                Driver: @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$object->driver])
                @endcomponent
            </label>
            <input name="driver_id" type="hidden" value="{{$object->driver->id}}">
        @endif
    </div>

    <div class="form-group">
        <label for="fname" class="col-form-label">
            Truck:  @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$object->truck])
            @endcomponent
        </label>
    </div>

    <div class="form-group row ">
        <div class="col-12">
            <label for="product" class="col-form-label">Service type</label>
            <select class="form-control form-control-lg" name="product">
                <option {{($object->product == 'oil') ? 'selected' : ''}} value="oil">Oil change</option>
                <option {{($object->product == 'rotation') ? 'selected' : ''}} value="rotation">Tire Rotation</option>
                <option {{($object->product == 'tirefix') ? 'selected' : ''}}  value="tirefix">Tire fix</option>
                <option {{($object->product == 'tire') ? 'selected' : ''}}  value="tire">New tire</option>
                <option {{($object->product == 'engine') ? 'selected' : ''}}  value="engine">Mechanic Engine</option>
                <option {{($object->product == 'suspension') ? 'selected' : ''}}  value="suspension">Mechanic Suspension</option>
                <option {{($object->product == 'body') ? 'selected' : ''}}  value="body">Body work</option>
                <option {{($object->product == 'wash') ? 'selected' : ''}}  value="wash">Wash</option>
                <option {{($object->product == 'other') ? 'selected' : ''}}  value="other">Other</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="message-text" class="col-form-label">Service details:</label>
        <textarea class="form-control" name="description" >{{$object->description}}</textarea>
    </div>

    <div class="form-group row">
        <div class="col-4">
            <label for="mileage" class="col-form-label">Service Mileage</label>
            <input name="mileage" class="form-control form-control-sm" type="text" value="{{$object->mileage}}" required>
        </div>
        <div class="col-auto">
            <label class="" for="total">Total charged</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                </div>
                <input type="text" class="form-control" id="total" name="total" value="{{$object->total}}" placeholder="0.00">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-6">
            <label for="shop" class="col-form-label">Shop Name</label>
            <input name="shop" value="{{$object->shop}}" class="form-control form-control-sm" type="text" required>
        </div>
        <div class="col-6">
            <label for="shop_phone" class="col-form-label">Shop phone</label>
            <input name="shop_phone" value="{{$object->shop_phone}}" class="form-control form-control-sm" type="phone" required>
        </div>
    </div>

    <div class="form-row ">
        <div class="row col-2">
            <div class="col-12 ">
                <a href="/img/service/{{$object->image}}" title='Open in new tab' target="_blank"><img class="w-100" src="/img/service/{{$object->image}}" alt="Uploaded image"></a>
            </div>
        </div>
        <div class="col-10 ">
            <input name="image" type="file" class="custom-file-input" id="image">
            <label class="custom-file-label" for="image">Update picture</label>
        </div>
    </div>

</div>

@if (Auth::user()->role_id>3)
    <div class="modal-footer">
        <input name="id" type="hidden" value="{{$object->id}}">
        <input name="truck_id" type="hidden" value="{{$object->truck->id}}">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
@else
    You dont have enough permition to update service
@endif
