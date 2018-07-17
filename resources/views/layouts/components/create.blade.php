<div class="modal-body">
    <form method="POST" action="/{{$modelName}}/store" @if ($file) enctype="multipart/form-data" @endif >
    {{ csrf_field() }}
    @component('layouts.components.create.'.$modelName,[
        'op1'=>$op1,
        'op2'=>$op2,
        'iterator'=>0
    ])

    @endcomponent

</form>
</div>
