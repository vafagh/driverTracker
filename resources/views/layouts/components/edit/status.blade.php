<div class="modal-body">

        {{$object->location->longName}}
        <input type="hidden" name="location_id" value="{{$object->location->id}}">

        @if ((Auth::user()->role_id > 2 || Auth::user()->id == $object->user_id))

            <div class="form-group select">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name='rescheduled'>
                  <label class="form-check-label" for="flexSwitchCheckDefault">Re deliver</label>
                </div>
            </div>
            <div class="form-group select">
            <div class=" px-4 py-2">
                @php
                    $radio = [//  0 a                                 1 b                     2 c
                                ["1. Shop were close ",               'work_off',             "Closed"],
                                ["2. Nobody signed it ",              'face_retouching_off',  "Nobody"],
                                ["3. Not Paid ",                      'money_off_csred',      "NoMoney"],
                                ["4. Dont Need it ",                  'do_not_touch',         "Canceled"],
                                ["5. Driver don`t have this ticket ", 'content_paste_off',    "NoTicket"],
                                ["6. Driver didn`t make it ",         'hourglass_disabled',   "NoTime"],
                                ["7. Part was damaged ",              'broken_image',         "Damaged"],
                                ["8. Wrong item sent ",               'rule',                 "Wrong"]
                            ];
                @endphp
                @foreach ($radio as $key => $value)

                <div class="form-check">
                    {{-- <h5 class="">{{$value[5]}}</h5> --}}
                        <input onclick="setTextAndCombo('description{{$object->id}}','status{{$object->id}}','{{$value[0]}}','{{$value[2]}}')" class="form-check-input" name='radio{{$object->id}}' type="radio" id='desc1Rad{{$object->id}}{{$key}}' value='{{$value[1]}}'>
                        <label class="form-check-label " for="desc1Rad{{$object->id}}{{$key}}">
                            <span class="material-icons">{{$value[1]}}</span>
                            <span>{{$value[0]}}</span>
                        </label>
                </div>
                @endforeach
            </div>
        @endif

        <div class="form-group">
            <label for="status{{$object->id}}" class="col-form-label">Status:</label>
            <input id="status{{$object->id}}" type=text name="status" value='1' >
        </div>
        <div class="form-group">
            <label for="description{{$object->id}}" class="col-form-label">Note:</label>
            <textarea id="description{{$object->id}}" class="form-control" name="description">{{$object->description}}</textarea>
        </div>

</div>
<div class="modal-footer">
    <input type="hidden" name="type" value="{{$object->type}}">
    <input type="hidden" name="id" value="{{$object->id}}">
    <input value="{{$object->invoice_number}}" type="hidden" class="form-control mb-2 col-4" name="invoice_number" placeholder="{{($op1=='Client') ? 'Invoice': 'Part'}} number" required>

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save it</button>
</div>
