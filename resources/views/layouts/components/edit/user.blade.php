<div class="modal-body">
    <div class="form-group">
        <label for="fname" class="col-form-label">Name</label>
        <input name="fname" class="form-control form-control-sm" type="text" value="{{$object->name}}" required>
    </div>

    <div class="form-group">
        <label for="email" class="col-form-label">Email Address</label>
        <input name="email" class="form-control form-control-sm" type="text" value="{{$object->email}}">
    </div>

    <div class="form-group">
        <label for="password" class="col-form-label">Password</label>
        <input name="password" class="form-control form-control-sm" type="password">
    </div>

    <div class="form-group">
        <label for="role" class="col-form-label">Role</label>
        <select class="form-control form-control-sm" name="role">
            <option {{($object->role_id ==0) ? 'selected':''}} value="0">Disable</option>
            <option {{($object->role_id ==1) ? 'selected':''}} value="1">Viewer</option>
            <option {{($object->role_id ==2) ? 'selected':''}} value="2">Sale</option>
            <option {{($object->role_id ==3) ? 'selected':''}} value="3">Warehouse Manager</option>
            <option {{($object->role_id ==4) ? 'selected':''}} value="4">Part Receiver</option>
            <option {{($object->role_id ==5) ? 'selected':''}} value="5">Admin</option>
        </select>
    </div>
{{--
    <div class="custom-file">
        <input name="avatar" type="file" class="custom-file-input" id="avatar">
        <label class="custom-file-label" for="customFile">Choose picture</label>
    </div> --}}

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
