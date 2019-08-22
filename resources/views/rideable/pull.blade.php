@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-header row m-0 h4 bg-primary text-light">
            <div class="col-10">
                Submit a pulled invoice
            </div>
        </div>

        <div class="card-body vertical-center">
            <div class="mx-auto ">
@if (isset($request) && $request->showForm == 'yes')
    <form action="/rideable/{{ ($update) ? 'save' : 'store' }}" method="post">
        {{ csrf_field() }}
        <div class="bigtext">
            <input class="digit" type="text" name="invoice_number{{ ($update) ? '' : '0' }}" maxlength="6" value="{{$last}}" readonly>
        </div>

        @if (empty($rideable))
            <fieldset class="border px-2 pb-2 mb-2 form-group autocomplete w-100">
                <legend class="w-auto px-2 my-0">For</legend>
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
                <input id="clientsName" type="text" name="locationName0"  placeholder="Type shop full name" class="form-control form-control w-100" style="display:none">
                <input id="clientsPhone" type="text" autofocus name="locationPhone0"  placeholder="Type the shop number" class="form-control form-control w-100" style="display:block" >
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

                    var cliName  = {{!!App\Helper::locations('Client','name')!!}};
                    var cliPhone  = {{!!App\Helper::locations('Client','phone')!!}};

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
            Customer: <div class="h2">{{($rideable->location->longName)}}</div>
            This ticket already marked as a <b class="text-danger">{{($rideable->status)}}</b>!<br>
            @if ($rideable->status == 'Created' || $rideable->status == 'DriverDetached' || $rideable->status == 'Reschedule' )
            @else
                Please duble check the ticket number and make sure ticket#<b>{{$rideable->invoice_number}}</b> is created for <b class="text-info">{{($rideable->location->longName)}}</b>.<br>
            @endif
            <input type="hidden" name="locationName0" value="{{$rideable->location->phone}}">
        @endif
        <div class="form-group">
            <div class="text-muted">
                {{(empty($rideable->description)?: 'Current note: '.$rideable->description)}}
            </div>
            <label for="message-text" class="col-form-label">Add a note:</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="row">
            @php
            $pullers = App\User::whereIn('role_id',[1,3])->get();
            @endphp
            <div class="pullerSelect pl-4 m-4">
                <div class="">
                    Select your name:
                </div>
                @foreach ($pullers as $key => $puller)
                    <div class="form-check d-inline ml-2">
                        <input class="form-check-input" type="radio" name="puller" id="puller1_{{$key}}_{{(isset($rideable->id))?$rideable->id:''}}" value="{{$puller->name}}"}}>
                        <label class="form-check-label" for="puller1_{{$key}}_{{(isset($rideable->id))?$rideable->id:''}}">
                            {{$puller->name}}
                            {{$puller->image}}<img class=" rounded" src="{{($puller->image == null) ? '/img/def.svg' : '/img/users/'.$puller->image }}" alt="{{$puller->name}}">
                        </label>
                    </div>
                @endforeach
                <div class="form-check d-inline ml-2">
                    <input class="form-check-input" type="radio" name="puller" id="puller1_00100" value="Not listed"}}>
                    <label class="form-check-label" for="puller1_00100">
                        Not listed!
                        <img class=" rounded" src="/img/def.svg" alt="not listed">
                    </label>
                </div>
            </div>
        </div>
        <input value='Pulled' type="hidden" name='status'>
        <input value='1' type="hidden" name='ready'>
        <input value='1' type="hidden" name='item_0'>
        <input value='1' type="hidden" name='onlyStatus'>
        <input type="hidden" name="type" value="Client">
        <input type="hidden" name="id" value="{{empty($rideable->id)?:$rideable->id}}">
        <button type="submit" class="btn btn-primary">Save it</button>
        <a href="/pull" class="btn btn-primary">Reset</a>
    </form>
@else
    <form action="/rideable/pull/" method="post" id='rideable_pull'>
        {{ csrf_field() }}
        <div class="bigtext mb-4">
            <input class="digit" type="text" name="invoice_number" maxlength="6" value="{{$last}}" id='innu'>
        </div>
        @foreach ($pickups as $key => $rideable)
            <a class="btn btn-warning text- my-1" href="#" onclick="document.getElementById('innu').value={{$rideable->invoice_number}}">{{$rideable->invoice_number}}</a>
        @endforeach
        <a class="btn btn-secondary text-light my-1" href="#" onclick="document.getElementById('innu').value=''">Clear</a>
        <button class="btn btn-primary" type="submit" name="button">Check</button>
    </form>

    @endif

            </div>
        </div>
    </div>
@endsection
