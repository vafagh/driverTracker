<div class="form-group when" id="delivery-form"{{(isset($whenDisplayNone)) ? ' style=display:none' : ''}}>
        <fieldset class="border px-4 mb-0 pb-0 form-group autocomplete w-100">
        @php
            $date = new DateTime('tomorrow');
            $currentHoure = date('H');
            $forceMorning = false;
            // if(date("l")=='Friday'){
            //     $deliverydate ='';}
            if (date("l")=='Saturday') {
                $date->add(new DateInterval('P1D'));
                $deliverydate = $date->format('Y-m-d');
                $forceMorning = true;
            }else {
                if($currentHoure <= 14){
                    $deliverydate = date('Y-m-d');
                }else{
                    $deliverydate = $date->format('Y-m-d');
                }
            }
            ($object == false or $object->id == null)?$object = 1:$object = $object;
            (isset($object->id) and $object->id!=Null) ? $previuslySet = $object->delivery_date:$previuslySet=false;
            $evening=''; $morning='';
            if($previuslySet){
                ($object->shift=='Morning') ? $morning='checked' : $evening='checked';
            }else ($currentHoure >= 13 or $forceMorning) ? $morning='checked' : $evening='checked';
        @endphp
        <legend class="w-auto py-1 my-0">When</legend>
        {!!($deliverydate =='')?'<span class="text-danger">Tomorrow or Monday?</span>':''!!}
        <div class="col-auto">
            <div class="input-group mb-2">
                <div class="input-group-prepend h-100">
                    <div class="input-group-text bg-white"><i class="material-icons">date_range</i></div>
                </div>
                <input class="form-control w-auto h-100" name="delivery_date" type="date"
                    min="{{Carbon\Carbon::yesterday()->toDateString()}}"
                    max="{{Carbon\Carbon::now()->addDays(7)->toDateString()}}"
                    value='{{($previuslySet&&(date("l")!='Friday'))?$previuslySet:$deliverydate}}' required>
            </div>
        </div>
        <div class="form-check mb-2 p-2">
            <input class="form-check-input mh-40" type="radio" name="shift" id="shift1_{{$model}}_{{(isset($object->id))?$object->id:''}}" value="Morning" {{$morning}}>
            <label class="form-check-label mh-40 lh-40" for="shift1_{{$model}}_{{(isset($object->id))?$object->id:''}}">
                <div class="shiftSelect morning"></div>
                Morning 08:00 to 13:00
            </label>
        </div>
        <div class="form-check p-2">
            <input class="form-check-input mh-40" type="radio" name="shift" id="shift2_{{$model}}_{{(isset($object->id))?$object->id:''}}" value="Evening" {{$evening}}>
            <label class="form-check-label mh-40 lh-40" for="shift2_{{$model}}_{{(isset($object->id))?$object->id:''}}">
                <div class="shiftSelect evening"></div>
                Evening 14:00 to 17:00
            </label>
        </div>
    </fieldset>
</div>
