@component('layouts.when',['object' => '', 'model' => 'create.rideable', 'when' => App\Helper::when(null)])
@endcomponent
<div class="modal-body">
    <div class="form-group">
        <label for="rawTextRideable" class="col-form-label">Paste ADV Negative Data</label>
        <textarea class="form-control" id="rawTextRideable" name="rawData"></textarea>
    </div>
</div>

<div class="modal-footer">
    <input type="hidden" name="type" value="">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
