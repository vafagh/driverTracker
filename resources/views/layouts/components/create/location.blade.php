<div class="modal-body">
    <div id='showPaste' style="display:inline" >
    <div class="form-group row">
        <div class="col-12 col-md-6">
            <label for="name" class="col-form-label">Location Name</label>
            <input name="name" id="name" class="form-control" type="text"  required>
        </div>
        <div class="col-12 col-md-6">
            <label for="person" class="col-form-label">Contact Person</label>
            <input name="person" id="person" class="form-control" type="text" required>
        </div>
    </div>

    <div class="form-group">
        <label for="longName" class="col-form-label">Long Name</label>
        <input name="longName" id="longName" class="form-control" type="text" required>
    </div>

    <div class="form-group">
        <div class="custom-file">
            <input name="image" id="image" type="file" class="custom-file-input" id="image">
            <label class="custom-file-label" for="image">Upload a Logo</label>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-7">
            <label for="phone" class="col-form-label">Phone</label>
            <input name="phone" id="phone" class="form-control" type="text" required>
        </div>
        <div class="col-5 row">

            <label for="type" class="col-form-label">Type:</label>
            <select class="form-control" name="type" id="type">
                <option value="Client">Client</option>
                <option value="Warehouse">Warehouse - pickup</option>
                <option value="DropOff">Warehouse - drop off</option>
            </select>
        </div>
    </div>


    <div class="form-group">
        <div class="row">
            <div class="col-7">
                <label for="line1" class="col-form-label">Address</label>
                <input name="line1" id="line1" class="form-control" type="text" placeholder="Line 1" required>
            </div>
            <div class="col-5 row">
                <label for="distance" class="col-form-label">Distance from Eagle</label>
                <div class="col-6">
                    <input name="distance" id="distance" class="form-control" type="text" required>
                </div>
                <div class="col-6 p-0 pt-2 pl-1">
                    mile
                </div>
            </div>
        </div>
        <input name="line2" id="line2" class="mt-1 form-control" type="text" placeholder="Line 2" >
        <div class="row m-0 p-0 row">
            <input name="city" id="city" class="mt-1 mr-1 col-5 form-control" type="text" placeholder="City" required>
            <input name="state" id="state" class="mt-1 mr-1 col-2 form-control" type="text" placeholder="State" value='TX' required>
            <input name="zip" id="zip" class="mt-1 col-4 form-control" type="text" placeholder="Zip Code" required>
        </div>
    </div>

        <a href="#" onClick="show(); return true;">Paste</a>

    <div class="modal-footer">
        <input name="id" type="hidden" >
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

    <!-- paste to fill -->
    <div class="form-group" id='paste' style="display:none">
        <label for="message-text" class="col-form-label">Paste customer information here</label>
        <textarea class="form-control" id="pastedText" name="description"></textarea>
        <a href="#" onClick="autoFill(); return true;">Click to Autofill</a>
    </div>
</div>
<script type="text/javascript">

function show() {
    document.getElementById('paste').style.display = 'inline';
    document.getElementById('showPaste').style.display = 'none';
}

function autoFill() {
    var cleanedText =  document.getElementById('pastedText').value.replace('NOTES', '').replace('Active? Y', '').replace('TAX ON FILE', '').replace('Contact', '').replace('Name', '').replace('Phone', '').replace('Fax', '').replace('CSZ', '').replace('Code', '').replace('Cr Limit', '').replace('Add1', '').replace('Add2', '').replace('Sls YTD', '').replace(/:/g, '\n').split("\n");
    let pastedText = cleanedText.map(str => str.trim());
    
    document.getElementById('name').value = pastedText[1];
    document.getElementById('person').value = pastedText[2];
    document.getElementById('longName').value = pastedText[4];
    document.getElementById('phone').value = pastedText[5];
    if(pastedText[10].indexOf('TAX') == -1){ document.getElementById('line2').value = pastedText[10];}
    if(pastedText[7].indexOf('#') == -1){
        document.getElementById('line1').value = pastedText[7];
    } else{
        document.getElementById('line1').value = pastedText[7].substring(0, pastedText[7].indexOf('#'));
        document.getElementById('line2').value = pastedText[7].substring(pastedText[7].indexOf('#'))
    }
    var lineLenghth = pastedText[13].length;
    document.getElementById('zip').value = pastedText[13].substring(lineLenghth - 5, lineLenghth);
    document.getElementById('city').value = pastedText[13].substring(0,lineLenghth - 5).replace('TX','').trim();
    document.getElementById('state').value = 'TX';
    document.getElementById('distance').value = 5;
    var selectElements = document.getElementsByName("type");
    for (var i=0; i<selectElements.length; i++) {if (selectElements[i].getAttribute('value') == 'Client') {selectElements[i].checked = true;}}

    document.getElementById('paste').style.display = 'none';
    document.getElementById('showPaste').style.display = 'inline';
}
</script>
