<a href="/locations" data-target="#op1location_createlocation0">
    <i class="material-icons">add_location</i>
    Create Location
</a>

<div class="modal-body">
    <div class="{{($op1 == 'Client')?'':'d-none'}}">

        @component('layouts.when',['object'=>$object,'model'=>'create.rideable'])
        @endcomponent
    </div>
    @if($op1 == 'Client')
        <fieldset class="border px-2 pb-2 mb-2 form-group autocomplete w-100">
            <legend class="w-auto px-2 my-0">To</legend>
            Search by:
            <div>
                <div class="form-check form-check-inline" >
                    <input class="form-check-input" type="radio" name="searchBy" id="cName" value="name" onclick="toggle()">
                    <label class="form-check-label" for="cName">Name</label>
                </div>
                <div class="form-check form-check-inline" >
                    <input class="form-check-input" checked type="radio" name="searchBy" id="cPhone" value="phone" onclick="toggle()">
                    <label class="form-check-label" for="cPhone">Phone</label>
                </div>
            </div>
            <input id="clientsName" type="text" name="locationName"  placeholder="Type shop full name" class="form-control form-control w-100" style="display:none">
            <input id="clientsPhone" type="text" autofocus name="locationPhone"  placeholder="Type the shop number" class="form-control form-control w-100" style="display:block" >
            @section('footer-scripts')
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
                    var cliName = {@foreach ($locations = App\Location::where('type',$op1)->orderBy('phone')->get() as $location)@if($loop->last)"{!!$location->longName.'":"'.$location->longName.' , '.$location->phone!!}"@else"{!!$location->longName.'":"'.$location->longName.' , '.$location->phone!!}",@endif @endforeach};
                    var cliPhone = {@foreach ($locations = App\Location::where('type',$op1)->orderBy('phone')->get() as $location)@if($loop->last)"{!!$location->longName.'":"'.$location->phone.' , '.$location->longName!!}"@else"{!!$location->longName.'":"'.$location->phone.' , '.$location->longName!!}",@endif @endforeach};
                    autocomplete(document.getElementById("clientsName"), cliName);
                    autocomplete(document.getElementById("clientsPhone"), cliPhone);
                    function toggle() {
                    var cName = document.getElementById("cName");
                    var cPhone = document.getElementById("cPhone");
                    var clientsName = document.getElementById("clientsName");
                    var clientsPhone = document.getElementById("clientsPhone");

                    if (cName.checked){
                        clientsPhone.value = "";
                        clientsPhone.style.display = "none";
                        clientsName.style.display = "block";
                        clientsName.focus();
                    }
                    if(cPhone.checked){
                        clientsName.value = "";
                        clientsPhone.style.display = "block";
                        clientsName.style.display = "none";
                        clientsPhone.focus();
                    }
                }
                </script>
            @endsection
        </fieldset>
    @else
        <fieldset class="border p-2 mb-2 form-group autocomplete w-100">
            <legend class="w-auto px-2 my-0">From</legend>
            <div class="form-group select">
                <select class="form-control locations" name="locationName" required>
                    @foreach (App\Location::where('type','!=','Client')->orderBy('name')->get() as $location)
                        <option value="{{$location->id}}">
                            {{$location->name}}
                        </option>
                    @endforeach
                    <option class="text-muted" disabled>Not found? Create it first</option>
                </select>
            </div>
        </fieldset>
    @endif

    @for ($i=0; $i < 10; $i++)
        <div class="form-inline row m-0" {{$i>0 ? "style=display:none":'"style=display:flex"'}} id="line{{$i}}">

            <label class="sr-only" for="invoice_number{{$i}}">{{($op1=='Client') ? 'Invoice': 'Part'}} number:</label>
            <input class="form-control m-0 mb-2 col-4 text-uppercase" id="invoice_number{{$i}}" type="text" name="invoice_number{{$i}}" placeholder="{{($op1=='Client') ? 'Invoice': 'Part'}} number">
            @if ($op1!='Client')
                <div class="col-4 mb-2">
                    <div class="form-check" >
                        <input class="form-check-input" type="checkbox" id="stock{{$i}}" name="stock{{$i}}">
                        <label class="form-check-label" for="stock{{$i}}">
                            For Stock
                        </label>
                    </div>
                </div>
            @endif
            <div class="col-4 row m-0 p-0">
                @if ($op1!='Client')
                    <div class="form-group col-9 mb-2">
                        <select id="qty{{$i}}" name="qty{{$i}}" class="form-control">
                            <option selected value='1'>QTY x1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                    </div>
                @endif
                <div id="delete{{$i}}" class="col-2" style='display:flex;'><a class='text-danger' href="#" onclick="hideID('{{$i}}')"><i class="material-icons">delete_forever</i></a></div>
            </div>
        </div>
    @endfor

    <script type="text/javascript">
        function showID(id) {
            if (id!=null) {
                id.style.display = "flex";
                let lineNm = document.getElementById("delete0").style.display = "none";
            }
        }
        function hideID(id) {
            if(id!=0){
                let lineNm = this["line"+id].style.display = "none";
            }else{
                let lineNm = document.getElementById("delete0").style.display = "none";
            }
            var invNum = this["invoice_number"+id];
            invNum.value = null;
        }
        document.addEventListener("keydown", function (event) {
        let currentIdNum = parseInt(event.srcElement.id.substr(event.srcElement.id.length - 1));
        let theId = event.srcElement.id.substr(0,event.srcElement.id.length - 1)
        let nextIdNum = currentIdNum+1;
        showID(document.getElementById("line"+nextIdNum));
        if (event.which==32 && nextIdNum!=NaN) {
            document.getElementById('invoice_number'+nextIdNum).focus();
        }
    });
    </script>

    <div clas}s="form-group">
        <label for="message-text" class="col-form-label">Note:</label>
        <textarea class="form-control" id="message-text" name="description"></textarea>
    </div>

</div>
<div class="modal-footer">
    <input type="hidden" name="type" value="{{$op2}}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" id="{{$op2}}" class="btn btn-primary">Save it</button>
</div>
