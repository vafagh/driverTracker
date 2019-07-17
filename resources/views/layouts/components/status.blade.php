<div class="modal-body">
    <div class="modal-body">
        <div class="row">
            @php
                $pullers = App\User::whereIn('role_id',[1,3])->get();
            @endphp
            @foreach ($pullers as $key => $puller)
                        <div class="">
                            <a class="col-3" title='click if it pulled by this person' href="/rideable/{{$object->id}}/Pulled?user={{$puller->id}}">
                                {{$puller->name}}
                            </a>
                            <img class="minh-100 rounded" src="{{($puller->image == null) ? '/img/def.svg' : '/img/users/'.$puller->image }}" alt="">
                        </div>
            @endforeach
        </div>

    </div>
    <div class="modal-footer">
        {{-- <input name="id" type="hidden" value="{{$object->id}}"> --}}
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="submit" class="btn btn-primary">Save it</button> --}}
    </div>

</div>
