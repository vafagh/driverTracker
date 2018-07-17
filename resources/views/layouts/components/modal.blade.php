@if (!isset($btnHide))
<button type="button" class=" {{(isset($style) ? $style : 'btn btn-primary float-right')}} {{(isset($btnSize) ? 'btn-sm mx-1' : '')}}" data-toggle="modal" data-target="#{{$op1.$op2.'_'.$action.$iterator}}" data-whatever="@mdo">
    {{ucfirst($action)}} {{ucfirst($op2)}}
</button>
@endif
<div class="modal fade text-dark" id="{{$op1.$op2.'_'.$action.$iterator}}" tabindex="-1" role="dialog" aria-labelledby="{{$op2.$action.$iterator}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$op2.$action.$iterator}}">{{ucfirst($action).' '.$op2}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @component('layouts.components.'.$action,[
            'modelName'=>$modelName,
            'op1'=>$op1,
            'op2'=>$op2,
            'action'=>$action,
            'object'=>$object,
            'file'=>(isset($file))?$file:false,
            // 'iterator'=>$iterator,
            'object'=>(isset($object))? $object:false
        ])

            @endcomponent
        </div>
    </div>
</div>
