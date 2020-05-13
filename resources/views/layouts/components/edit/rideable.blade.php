<div class="modal-body">
    @if($noneStatus)
        @if($object->location->type == 'Client')
            <div class="form-group">
                @if ($object->delivery_date!=null)
                    <span class="h6">Delivery arranged for:</span>
                    <div class="h4 text-center">
                        {{ App\Helper::dateName($object->delivery_date)}}, {{$object->shift}}
                    </div>
                @endif
                <a data-toggle="collapse" href="#collapse-edit-{{$object->id}}" role="button" aria-expanded="{{ (date("l")=='Friday') ? 'true' : 'false' }}" aria-controls="collapse-edit-{{$object->id}}">
                    Re-schedule
                </a>
                <div class="collapse{{($object->delivery_date==null)?' show':''}}" id="collapse-edit-{{$object->id}}">
                    <div class="">
                        @component('layouts.when',['object'=>$object,'model'=>'create.ride', 'when' => App\Helper::when($object)])
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif
                @if($object->location->type != 'Client')
                    <fieldset class="border p-2 mb-2 form-group autocomplete w-100">
                        <legend class="w-auto px-2 my-0">From</legend>
                        <div class="form-group select">
                            <select class="form-control locations" name="location_id" required>
                                <option value>
                                    Select one
                                </option>
                                @foreach ($allwarehouse as $location)
                                    <option value="{{$location->id}}" {{($object->location_id == $location->id)?' selected ':''}}>
                                        {{$location->name}}
                                    </option>
                                @endforeach
                                <option class="text-muted" disabled>Not found? Create it first</option>
                            </select>
                        </div>
                    </fieldset>
                @else
                    {{$object->location->longName}}
                    <input type="hidden" name="location_id" value="{{$object->location->id}}">
                @endif

        @if ((Auth::user()->role_id > 2 || Auth::user()->id == $object->user_id))

            <div class="form-group select">
                <label for="status{{$object->id}}" class="col-form-label">Status:</label>
                <select class="form-control locations" name="status" id="status{{$object->id}}" required>
                    <option value>Select one</option>
                    @foreach (App\Helper::filter('all') as $value)
                        <option {{($value==$object->status) ? 'selected' : ''}} value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-inline row m-0">
            <input value="{{$object->invoice_number}}" type="text" class="form-control mb-2 col-4" name="invoice_number" placeholder="{{($op1=='Client') ? 'Invoice': 'Part'}} number" required>
            @if ($op1!='Client')
                <div class="col-5 h6 mb-2  p-0 m-0">
                    <div class="form-check" >
                        <input  {{ $object->stock ? 'checked' : '' }} class="form-check-input " type="checkbox" name="stock">
                        For Stock
                    </div>
                </div>
                <div class="form-group col-3  mb-2">
                    <select name="qty" class="form-control">
                        @php $oneToNine = [1,2,3,4,5,6,7,8,9]; @endphp
                        @foreach ($oneToNine as $value)
                            <option {{( $value == $object->qty ) ? 'selected' : ''}} value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="input-group mb-2">
                    <div class="input-group-prepend ml-2">
                        <div class="input-group-text">$</div>
                    </div>
                    <input name="qty" type="text" class="form-control" value="{{$object->qty}}">
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="message-text" class="col-form-label">Note:</label>
            <textarea class="form-control" name="description">{{$object->description}}</textarea>
        </div>

        @if ($object->rides->count()>0  && $noneStatus)
            <hr class="mt-0">
            <div class="">
                <h4>Assigned to:</h4>
                @foreach ($object->rides as $key => $ride)
                    <div>
                        {{$ride->id}}:{{$ride->driver->fname}} with {{$ride->truck->lable}}
                        <a href="/ride/detach/{{$ride->id}}/{{$object->id}}"><i class="material-icons md-16">remove_circle_outline</i></a>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <input value='kiloklo' type="hidden" name='onlyStatus'>
        <input value='Pulled' type="hidden" name='status'>
        <div class="form-group">
            <label for="message-text" class="col-form-label">Note:</label>
            <textarea class="form-control" name="description">{{$object->description}}</textarea>
        </div>
        <div class="row">
            @php
                $pullers = App\User::whereIn('role_id',[1,3])->get();
            @endphp
            <div class="pullerSelect pl-4 m-0">
                @foreach ($pullers as $key => $puller)
                    <div class="form-check d-inline ml-2">
                        <input class="form-check-input" type="radio" name="puller" id="puller1_{{$key}}_{{(isset($object->id))?$object->id:''}}" value="{{$puller->name}}"}}>
                        <label class="form-check-label" for="puller1_{{$key}}_{{(isset($object->id))?$object->id:''}}">
                            {{$puller->name}}
                            <img class=" rounded" src="{{($puller->image == null) ? '/img/def.svg' : '/img/users/'.$puller->image }}" alt="">
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
<div class="modal-footer">
    <input type="hidden" name="type" value="{{$object->type}}">
    <input type="hidden" name="id" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
