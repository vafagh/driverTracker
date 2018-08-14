<a href="/locations#op1location_create0">Create Location</a>
<div class="modal-body">
    @if ($object->type == 'Delivery')
        <div class="form-group autocomplete w-100">
            <label for="lname" class="col-form-label">To:</label><br>
            <input id="ClientsAuto_{{$iterator}}"  onClick="this.setSelectionRange(0, this.value.length)" type="text" name="location" value="{{$object->location->longName}}" placeholder="Type in shop name" class="form-control form-control w-100" required >
        </div>
        <script type="text/javascript">
        var clients =
        {@foreach ($locations = App\Location::where('type','=','Client')->orderBy('phone')->get() as $location)
            @if($loop->last)
                "{!!$location->longName.'":"'.$location->phone!!}"
            @else
                "{!!$location->longName.'":"'.$location->phone!!}",
            @endif
        @endforeach};
        autocomplete(document.getElementById("ClientsAuto_{{$iterator}}"), clients);
        </script>
    @else
        <div class="form-group select">
            <label for="recipient-name" class="col-form-label">From:</label>
            <select class="form-control form-control-lg locations" name="location" required>
                @foreach (App\Location::where('type','!=','Client')->orderBy('name')->get() as $location)
                    <option {{($location->id==$object->location_id) ? 'selected' : ''}} value="{{$location->id}}">
                        {{$location->name}}
                    </option>
                @endforeach
                <option class="text-muted" disabled>Not found? Create it first</option>
            </select>
        </div>
    @endif
    @if (Auth::user()->role_id > 2 || Auth::user()->id == $object->user_id)

        <div class="form-group select">
            <label for="status" class="col-form-label">Status:</label>
            <select class="form-control form-control-lg locations" name="status" required>
                <option class="text-muted" disabled> select</option>
                <option {{('Created'==$object->status) ? 'selected' : ''}} value="Created">Created</option>
                <option {{('OnTheWay'==$object->status) ? 'selected' : ''}} value="OnTheWay">On The Way</option>
                <option {{('Done'==$object->status) ? 'selected' : ''}} value="Done">Done</option>
                <option {{('CancelReq'==$object->status) ? 'selected' : ''}} value="CancelReq">Cancel Request</option>
                <option {{('NotAvailable'==$object->status) ? 'selected' : ''}} value="NotAvailable">Not Available</option>
                <option {{('DeatachReqested'==$object->status) ? 'selected' : ''}} value="DeatachReqested">Cancel this Ride</option>
                <option {{('Reactived'==$object->status) ? 'selected' : ''}} value="Reactive">Re active</option>
                <option {{('Canceled'==$object->status) ? 'selected' : ''}} value="Canceled">Cancel</option>
            </select>
        </div>
    @endif
    <div class="form-group">
        <label for="message-text" class="col-form-label">{{($op1=='Client') ? 'Invoice': 'Part'}}#:</label>
        <textarea class="form-control" name="invoice_number" placeholder="Enter the number" required>{{$object->invoice_number}}</textarea>
        <div class="text-muted">
            Each part/invoice number on one line
        </div>
    </div>
    <div class="form-group">
        <label for="message-text" class="col-form-label">Note:</label>
        <textarea class="form-control" id="message-text" name="description"></textarea>
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name="type" value="{{$object->type}}">
    <input type="hidden" name="id" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
