<!--Modal start-->
@if (!isset($btnHide))
    <a  class="{{(isset($style) ? $style : 'btn btn-primary')}}{{(isset($btnSize) ? $btnSize : '')}}" data-toggle="modal" {{(isset($btnAttribute) ? $btnAttribute : '')}} data-target="#{{$op1.$op2.'_'.$action.$modelName.$iterator}}" data-whatever="@mdo" title="{{$action.' '.$modelName}}">
        {!!(isset($dingbats))? $dingbats : ucfirst($action)!!}
    </a>
@endif
<div class="modal fade text-dark h6" id="{{$op1.$op2.'_'.$action.$modelName.$iterator}}" tabindex="-1" role="dialog" aria-labelledby="{{$op1.$op2.$action.$modelName.$iterator}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="{{$op1.$op2.$action.$modelName.$iterator}}">{{ucfirst($action).' '.$op2}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                @component('layouts.components.'.$action,[
                    'modelName'=>$modelName,
                    'op1'=>$op1,
                    'op2'=>$op2,
                    'action'=>$action,
                    'file'=>(isset($file))?$file:false,
                    'autocomplateOff'=>(isset($autocomplateOff))?$autocomplateOff:false,
                    'object'=>(isset($object))? $object:false,
                    'iterator'=>$iterator])
                @endcomponent
        </div>
    </div>
</div>
<!--Modal End-->
