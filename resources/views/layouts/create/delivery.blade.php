<div class="form-group">
  <label for="recipient-name" class="col-form-label">From({{$op1}}):</label>
  <select class="form-control form-control-sm">
      @foreach (App\Location::where('type',$op1)->get() as $location)
          <option>{{$location->name.', '.$location->line1.', '.$location->city}}</option>
      @endforeach
  </select>
</div>
<div class="form-group">
  <label for="message-text" class="col-form-label">Invoice/Part#:</label>
  <input class="form-control form-control-sm" type="text" placeholder="Enter the Invoice number">
</div>
<div class="form-group">
  <label for="message-text" class="col-form-label">Note:</label>
  <textarea class="form-control" id="message-text"></textarea>
</div>
