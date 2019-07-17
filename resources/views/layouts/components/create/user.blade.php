<div class="modal-body">
    <div class="form-group">
        <label for="fname" class="col-form-label">Name</label>
        <input name="fname" class="form-control form-control-sm" type="text" placeholder="User first name" required>
    </div>

    <div class="form-group">
        <label for="email" class="col-form-label">Email Address</label>
        <input name="email" class="form-control form-control-sm" type="text" value="@eagleautobody.com" required>
    </div>

    <div class="form-group">
        <label for="password" class="col-form-label">Password</label>
        <input name="password" class="form-control form-control-sm" type="password" required>
    </div>

    <div class="form-group">
        <label for="role" class="col-form-label">Role</label>
        <select class="form-control form-control-sm" name="role">
            @foreach (['Disable' => 0, 'Warehouse puller' => 1, 'Sale' => 2, 'Warehouse Manager' => 3, 'Part Receiver' => 4, 'Admin' => 5] as $key => $value)
                <option value={{$value}}>{{$key}}</option>
            @endforeach
        </select>
    </div>

    {{-- <div class="custom-file">
        <input name="avatar" type="file" class="custom-file-input" id="avatar">
        <label class="custom-file-label" for="customFile">Choose picture</label>
    </div> --}}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
