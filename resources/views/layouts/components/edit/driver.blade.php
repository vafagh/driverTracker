<div class="modal-body">
    <div class="form-group">
        <label for="fname" class="col-form-label">First Name</label>
        <input name="fname" class="form-control form-control" type="text" value="{{$object->fname}}" required>
    </div>
    <div class="form-group">
        <label for="lname" class="col-form-label">Last Name</label>
        <input name="lname" class="form-control form-control" type="text" value="{{$object->lname}}" required>
    </div>
    <div class="form-group">
        <label for="phone" class="col-form-label">Phone number</label>
        <input name="phone" class="form-control form-control" type="text" value="{{$object->phone}}">
    </div>
    <div class="form-group">
        <label for="email" class="col-form-label">Email Address</label>
        <input name="email" class="form-control form-control" type="text" value="{{$object->email}}">
    </div>

    <div class="form-row ">
        <div class="row col-2">
            <div class="col-12 ">
                <img class="w-100" src="/img/avatars/{{$object->image}}" alt="">
            </div>
        </div>
        <div class="col-10 ">
            <input name="avatar" type="file" class="custom-file-input" id="avatar">
            <label class="custom-file-label" for="customFile">Update picture</label>
        </div>
    </div>

</div>
<div class="modal-footer">
    <input name="id" type="hidden" value="{{$object->id}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
