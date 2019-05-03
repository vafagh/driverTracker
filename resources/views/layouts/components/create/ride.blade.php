<div class="modal-body">
    @php
        $drivers = App\Driver::where('truck_id','!=',null)->orderBy('fname')->get();
    @endphp

    <div class="form-group">
        @if ($object->delivery_date!=null)
            <span class="h6">Delivery arranged for:</span>
            <div class="h4 text-center">
                {{ App\Helper::dateName($object->delivery_date)}}, {{$object->shift}}
            </div>
        @endif
        <a data-toggle="collapse" href="#collapse-reschedule-{{$object->id}}" role="button" aria-expanded="{{($object->delivery_date==null)?'true':'false'}}" aria-controls="collapse-reschedule-{{$object->id}}">
            Re-schedule
        </a>
        <div class="collapse{{($object->delivery_date==null)?' show':''}}" id="collapse-reschedule-{{$object->id}}">
            <div class="card card-body">
                @component('layouts.when',['object'=>$object,'model'=>'create.ride', 'when' => App\Helper::when($object)])
                @endcomponent
            </div>
        </div>
    </div>


    <div class="form-group">
        <label for="driver" class="col-form-label">
            {{$drivers->count()}} driver with truck:
        </label>
        <select class="form-control selectpicker" name="driver" title="Select your surfboard" required>
            <option></option>
            @foreach ( $drivers as $driver)
                <option value="{{$driver->id}}"> <img src="/img/driver/{{$driver->image}}" alt=""> {{$driver->fname}} - {{App\Truck::find($driver->truck_id)->lable}}</option>
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
