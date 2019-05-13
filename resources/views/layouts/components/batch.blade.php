<div class="modal-body">
    <form method="POST" action="/{{$modelName}}/batch"
    @if ($file) enctype="multipart/form-data" @endif>
    {{ csrf_field() }}
    @component('layouts.components.batch.'.$modelName,[
        'object'=>$object,
        'componentName'=>'batch',
        'iterator'=>0
        ]) @endcomponent

</form>
</div>
