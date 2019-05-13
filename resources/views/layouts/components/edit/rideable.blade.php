<div class="modal-body">
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
    <div class="form-group ">
        <label for="lname" class="col-form-label">To:</label>
        <div class="">
            {{$object->location->longName}}
        </div>
    </div>
    @if (Auth::user()->role_id > 2 || Auth::user()->id == $object->user_id)

        <div class="form-group select">
            <label for="status" class="col-form-label">Status:</label>
            <select class="form-control locations" name="status" required>
                <option class="text-muted" disabled> select</option>
                <option {{('Created'==$object->status) ? 'selected' : ''}} value="Created">Created</option>
                <option {{('OnTheWay'==$object->status) ? 'selected' : ''}} value="OnTheWay">On The Way</option>
                <option {{('Done'==$object->status) ? 'selected' : ''}} value="Done">Done</option>
                <option {{('Returned'==$object->status) ? 'selected' : ''}} value="Returned">Returned</option>
                <option {{('CancelReq'==$object->status) ? 'selected' : ''}} value="CancelReq">Cancel Request</option>
                <option {{('NotAvailable'==$object->status) ? 'selected' : ''}} value="NotAvailable">Not Available</option>
                <option {{('Reactived'==$object->status) ? 'selected' : ''}} value="Reactive">Re active</option>
                <option {{('Canceled'==$object->status) ? 'selected' : ''}} value="Canceled">Cancel</option>
            </select>
        </div>
    @endif
    <div class="form-inline row m-0">
        <input value="{{$object->invoice_number}}" type="text" class="form-control mb-2 col-4" id="invoice_number" name="invoice_number" placeholder="{{($op1=='Client') ? 'Invoice': 'Part'}} number" required>
        @if ($op1!='Client')
            <div class="col-5 h6 mb-2  p-0 m-0">
                <div class="form-check" >
                    <input  {{$object->stock ? 'checked' : ''}} class="form-check-input " type="checkbox" id="stock" name="stock">
                    For Stock
                </div>
            </div>

            <div class="form-group col-3  mb-2">
                <select id="qty" name="qty" class="form-control" required>
                    <option disabled value=1 >qty</option>
                    <option {{$object->qty ==1 ? 'selected' : ''}} value=1>1</option>
                    <option {{$object->qty ==2 ? 'selected' : ''}} value=2>2</option>
                    <option {{$object->qty ==3 ? 'selected' : ''}} value=3>3</option>
                    <option {{$object->qty ==4 ? 'selected' : ''}} value=4>4</option>
                    <option {{$object->qty ==5 ? 'selected' : ''}} value=5>5</option>
                    <option {{$object->qty ==6 ? 'selected' : ''}} value=6>6</option>
                    <option {{$object->qty ==7 ? 'selected' : ''}} value=7>7</option>
                    <option {{$object->qty ==8 ? 'selected' : ''}} value=8>8</option>
                    <option {{$object->qty ==9 ? 'selected' : ''}} value=9>9</option>
                    <option {{$object->qty ==10 ? 'selected' : ''}} value=10>10</option>
                </select>
            </div>
        @endif
    </div>
    <div class="form-group">
        <label for="message-text" class="col-form-label">Note:</label>
        <textarea class="form-control" id="message-text" name="description">{{$object->description}}</textarea>
    </div>
</div>
@if ($object->rides->count()>0)
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
<div class="modal-footer">
    <input type="hidden" name="type" value="{{$object->type}}">
    <input type="hidden" name="id" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
