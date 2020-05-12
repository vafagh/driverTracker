<div class="modal-body">
    <form method="POST" action="/{{$modelName}}/{{$name}}"
    @if ($file) enctype="multipart/form-data" @endif
        @if ($autocomplateOff) autocomplete="off" @endif>
            {{ csrf_field() }}
            @component('layouts.components.button.'.$name,[
                'iterator'=>(isset($object->id))? $object->id:false
            ])
        @endcomponent
    </form>
</div>
