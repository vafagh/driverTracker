<div class="modal-body">
    <div class="form-group">
        <label for="fname" class="col-form-label">Name</label>
        <input name="fname" class="form-control form-control-sm" type="text" placeholder="User first name" required>
    </div>

    <div class="form-group">
        <label for="email" class="col-form-label">Email Address</label>
        <input name="email" class="form-control form-control-sm" type="text" placeholder="example@eagleautobody.com" required>
    </div>

    <div class="form-group">
        <label for="password" class="col-form-label">Password</label>
        <input name="password" class="form-control form-control-sm" type="password" required>
    </div>

    <div class="form-group">
        <label for="role" class="col-form-label">Role</label>
        <select class="form-control form-control-sm" name="role">
            <option value="0">Disable</option>
            <option value="1">Viewer</option>
            <option value="2">Sale</option>
            <option value="3">Warehouse Manager</option>
            <option value="4">Part Receiver</option>
            <option value="5">Admin</option>
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
