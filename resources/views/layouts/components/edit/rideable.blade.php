<div class="modal-body">
<div class="form-group">
  <label for="recipient-name" class="col-form-label">From:</label>
  <select class="form-control form-control-lg" name="location">
      @foreach (App\Location::where('type',$op1)->get() as $location)
          <option value="{{$location->id}}">{{$location->name.', '.$location->line1.', '.$location->city}}</option>
      @endforeach
  </select>
</div>
<div class="form-group">
  <label for="message-text" class="col-form-label">Invoice/Part#:</label>
  <input class="form-control form-control-lg" name="invoice_number" type="text" placeholder="Enter the Invoice/Part number">
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
