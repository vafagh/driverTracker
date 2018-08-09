<div class="modal-body">
    <form method="POST" action="/{{$modelName}}/save"
    @if ($file) enctype="multipart/form-data" @endif >
    {{ csrf_field() }}
    @component('layouts.components.edit.'.$modelName,[
        'op1'=>$op1,
        'op2'=>$op2,
        'object'=>$object
        ]) @endcomponent

</form>
</div>
