<div class="modal-body">
    <form method="POST" action="/ride/{{$action}}" >
        {{ csrf_field() }}
        @component('layouts.components.'.$action.'.'.$modelName,['object'=>$object])
        @endcomponent
    </form>
</div>
