<a href="/locations#op1location_create0">Create Location</a>
<div class="modal-body">

    @if ($op1 == 'Client')
        <div class="form-group autocomplete w-100">
            <label for="lname" class="col-form-label">To:</label><br>
            <input id="ClientsAuto" type="text" name="location" placeholder="Type in shop name" class="form-control form-control w-100" required >
        </div>
        <script>
        /*initiate the autocomplete function on the "ClientsAuto" element,
        and pass along the clients array as possible autocomplete values:*/
        var clients = [@foreach ($locations = App\Location::where('type',$op1)->orderBy('longName')->get() as $location)@if($loop->last)"{{$location->name}}"@else"{{$location->name}}",@endif @endforeach];
        </script>
    @else
        <div class="form-group select">
            <label for="recipient-name" class="col-form-label">From:</label>
            <select class="form-control form-control-lg locations" name="location" required>
                @foreach (App\Location::where('type','!=','Client')->orderBy('name')->get() as $location)
                    <option value="{{$location->id}}">
                        {{$location->name}}
                    </option>
                @endforeach
                <option class="text-muted" disabled>Not found? Create it first</option>
            </select>
        </div>
    @endif










    <div class="form-group">
        <label for="message-text" class="col-form-label">{{($op1=='Client') ? 'Invoice': 'Part'}}#:</label>
        <textarea class="form-control" name="invoice_number" placeholder="Enter the number" required></textarea>
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
    <input type="hidden" name="type" value="{{$op2}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
