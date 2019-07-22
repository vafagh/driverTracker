<div class="form-group when" id="delivery-form"{{(isset($whenDisplayNone)) ? ' style=display:none' : ''}}>
    <fieldset class="border px-4 mb-0 pb-0 form-group autocomplete w-100">
        <legend class="w-auto py-1 my-0">When</legend>
        {!!($when['date'] == 0)?'<span class="text-danger">Tomorrow or Monday?</span>':''!!}
        <div class="col-auto">
            <div class="input-group mb-2">
                <div class="input-group-prepend h-100">
                    <div class="input-group-text bg-white p-2"><i class="material-icons">date_range</i></div>
                </div>
                <input class="form-control w-auto h-100 lh-26" name="delivery_date" type="date" min="{{Carbon\Carbon::now()->subDays(2)->toDateString()}}" max="{{Carbon\Carbon::now()->addDays(2)->toDateString()}}" value='{{$when['date']}}' required>
            </div>
        </div>
        <div class="shiftSelect pl-4 ">
            <div class="form-check mb-2 p-2">
                <input class="form-check-input" type="radio" name="shift" id="shift1_{{$model}}_{{(isset($object->id))?$object->id:''}}" value="Morning" {{($when['shift']=='Morning')?'checked':''}}>
                <label class="form-check-label morning" for="shift1_{{$model}}_{{(isset($object->id))?$object->id:''}}">
                    Morning 08:00 to 13:00
                </label>
            </div>
            <div class="form-check p-2 ">
                <input class="form-check-input" type="radio" name="shift" id="shift2_{{$model}}_{{(isset($object->id))?$object->id:''}}" value="Evening" {{($when['shift']=='Evening')?'checked':''}}>
                <label class="form-check-label evening" for="shift2_{{$model}}_{{(isset($object->id))?$object->id:''}}">
                    Evening 14:00 to 17:00
                </label>
            </div>
        </div>
    </fieldset>
</div>
