<div class="modal-body">
    <form method="POST" action="/{{$modelName}}/save"
    @if ($file) enctype="multipart/form-data" @endif
        @if ($autocomplateOff) autocomplete="off" @endif>
            {{ csrf_field() }}
            @component('layouts.components.edit.'.$modelName,[
                'op1'=>$op1,
                'op2'=>$op2,
                'object'=>$object,
                'componentName'=>'edit',
                'noneStatus' => (isset($noneStatus))? $noneStatus:true ,
                'iterator'=>$object->id
            ])
        @endcomponent
    </form>
</div>
