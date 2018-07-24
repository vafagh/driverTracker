<a href="/locations#op1location_create0">Create Location</a>
<div class="modal-body">
    <div class="form-group select">
        <label for="recipient-name" class="col-form-label">{{($op1=='Client') ? 'To': 'From'}}:</label>
        <select class="form-control form-control-lg locations" name="location" required>
            <option class="text-muted">Select</option>
            @if ($op1=='Client')
                @foreach (App\Location::where('type',$op1)->orderBy('phone')->get() as $location)
                    <option value="{{$location->id}}">
                        {{$location->phone}}&nbsp;{{$location->zip}}&nbsp;{{$location->longName}}
                    </option>
                @endforeach
            @else
                @foreach (App\Location::where('type',$op1)->orderBy('name')->get() as $location)
                    <option value="{{$location->id}}">
                        {{$location->name}}
                    </option>
                @endforeach
            @endif
            <option class="text-muted">Not found? Create it first</option>
        </select>
    </div>
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
