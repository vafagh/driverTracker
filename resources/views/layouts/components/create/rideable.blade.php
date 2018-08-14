<a href="/locations#op1location_create0">Create Location</a>
<div class="modal-body">

    @if ($op1 == 'Client')
        <div class="form-group autocomplete w-100">
            <label for="lname" class="col-form-label">To:</label><br>
            <input id="ClientsAuto" type="text" name="location"  placeholder="Type in shop name" class="form-control form-control w-100" required >
        </div>
        <script type="text/javascript">
            function autocomplete(inp, phoneBook) {
                var currentFocus;
                inp.addEventListener("input", function(e) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");
                    this.parentNode.appendChild(a);
                    for (const pNumber in phoneBook) {
                        if (phoneBook[pNumber].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                            b = document.createElement("DIV");
                            b.innerHTML = "<strong class='pr-2'>" + phoneBook[pNumber].substr(0, val.length) + "</strong>";
                            b.innerHTML += phoneBook[pNumber].substr(val.length);
                            b.innerHTML += "<input type='hidden' value='" + pNumber + "'>";
                            b.addEventListener("click", function(e) {
                                inp.value = this.getElementsByTagName("input")[0].value;
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                });
                inp.addEventListener("keydown", function(e) {
                    var x = document.getElementById(this.id + "autocomplete-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        currentFocus++;
                        addActive(x);
                    } else if (e.keyCode == 38) { //up
                        currentFocus--;
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        e.preventDefault();
                        if (currentFocus > -1) {
                            if (x) x[currentFocus].click();
                        }
                    }
                });
                function addActive(x) {
                    if (!x) return false;
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    x[currentFocus].classList.add("autocomplete-active");
                }
                function removeActive(x) {
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active");
                    }
                }
                function closeAllLists(elmnt) {
                    var x = document.getElementsByClassName("autocomplete-items");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }
            var clients = {@foreach ($locations = App\Location::where('type',$op1)->orderBy('phone')->get() as $location)@if($loop->last)"{!!$location->longName.'":"'.$location->phone.' , '.$location->longName!!}"@else"{!!$location->longName.'":"'.$location->phone.' , '.$location->longName!!}",@endif @endforeach};
            autocomplete(document.getElementById("ClientsAuto"), clients);
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
