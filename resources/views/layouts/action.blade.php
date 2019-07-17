@php
    $user_role = Auth::user()->role_id;
    $user_id = Auth::user()->id;
    $admin = 5;
    $title = 'Done';

    if($rideable->location->type=='Client')   $title = 'Delivered';
    if($rideable->location->type=='Warehouse')  $title = 'Picked up';
    if($rideable->location->type=='DropOff')  $title = 'Droped off';

    $delete         = false;
    $assignDriver   = false;
    $done           = false;
    $doneAtach      = false;
    $clear          = false;
    $notAvailable   = false;
    $detachReq      = false;
    $return         = false;
    $reschedule     = false;
    $pulled     = false;

if (($user_id == $rideable->user_id) || $user_role > 2 ){
    switch($action){
        case 'Created':
            ($user_id == $rideable->user_id) ? $delete = true :"";
            if ($rideable->location->name == 'IND' ){
                $pulled = true;
            }elseif($rideable->location->type == 'Client' && $rideable->location->name != 'IND' ){
                $pulled = true;
                $assignDriver = true;
            }else{
                $notAvailable = true;
                if($rideable->location->type == 'DropOff'){
                    $done = true;
                }elseif(!empty($rideable->location->driver_id) && $rideable->location->type == 'Warehouse' && $user_role > 2 && !empty(App\Driver::find($rideable->location->driver_id)->truck_id)){
                    $doneAtach = true;
                }
            }

        break;

        case 'Returned':
            if ($user_role >3){
                $done = true;
                $reschedule = true;
            }
        break;

        case 'DriverDetached':
            if ($user_id == $rideable->user_id) $delete = true;
            ($rideable->location->type  == 'Client') ?$assignDriver = true : $done = true;
            $pulled = true;
        break;

        case 'Reschedule':
            ($user_id == $rideable->user_id) ? $delete = true : "";
            ($rideable->location->type != 'DropOff') ?$assignDriver = true : "";
            ($title=='Droped off') ? $done = true : "";
        break;

        case 'OnTheWay':
            ($title != 'Delivered' || $rideable->location->type != 'Client') ? $notAvailable = true : $return = true;

            if ( $rideable->location->type == "Client")
                {$done = true;}
            elseif(!empty($rideable->location->driver_id) && $rideable->location->type == 'Warehouse' && $user_role > 2 && !empty(App\Driver::find($rideable->location->driver_id)->truck_id))
                {$doneAtach = true;}
        break;

        case 'DeatachReqested':
            if ($user_role > 3)
                $done = true;
        break;

        case 'NotAvailable':
            // if (empty($rideable->rides))
                if (($user_role >= 3))
                    $clear = true;
             // else
             //    Remove the attached driver
             // endif
        break;

        case 'Double Entry':
            $delete = true;
        break;

        default :
        if (Auth::user()->role_id > 6){
            $reschedule = true;
            $done = true;
            $notAvailable = true;
            $detachReq = true;
            $assignDriver = true;
            $delete = true;
            $pulled = true;
            }
    }
}

@endphp

@if ($delete)
    <a title="Cancel" class="text-danger" href="/rideable/delete/{{$rideable->id}}/"><i class="material-icons">delete_forever</i></a>
@endif
@if ($assignDriver)
    @component('layouts.components.modal',['modelName'=>'ride','action'=>'create','iterator'=>$rideable->id,'object'=>$rideable,'btnSize'=>'small','style'=>'text-info text-white ','op1'=>'','op2'=>'','dingbats'=>'<i class="material-icons">drive_eta</i> ','file'=>false])
    @endcomponent
@endif
@if ($done)
    <a class=" showOnHover" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i></a>
@endif
@if ($doneAtach)
    <a class="text-primary" title="Attach and Done" href='/ride/store/{{$rideable->id}}/{{$rideable->location->driver_id}}/Done'><i class="material-icons">done_outline</i></a>
@endif
@if ($clear)
    <a title="Clear line" class="text-danger" href="/rideable/{{$rideable->id}}/Canceled">
        <i class="material-icons">clear_all</i>
    </a>
@endif
@if ($notAvailable)
    <a title="Parts not available" class="text-danger showOnHover" href="/rideable/{{$rideable->id}}/NotAvailable"><i class="material-icons">priority_high</i></a>
@endif
@if ($detachReq)
    <a title="Request warehouse manager to dissmis driver from this ticket" class="text-danger" href="/rideable/{{$rideable->id}}/DeatachReqested"><i class="material-icons ">remove_circle_outline</i></a>
@endif
@if ($return)
    <a title="Returned" class=" showOnHover" href="/rideable/{{$rideable->id}}/Returned"><i class="material-icons">keyboard_return</i></a>
@endif
@if ($reschedule)
    <a class="text-primary showOnHover" title="Send driver back" href="/rideable/{{$rideable->id}}/Reschedule"><i class="material-icons">refresh</i></a>
@endif
@if ($pulled)
    @component('layouts.components.modal',['modelName'=>'status','action'=>'status','iterator'=>$rideable->id,'object'=>$rideable,'btnSize'=>'small','style'=>'text-info text-white ','op1'=>'','op2'=>'','dingbats'=>'<i class="material-icons">store</i> ','file'=>false])
    @endcomponent
    {{-- <a class="text-primary showOnHover" title="Picked up in store" href="/rideable/{{$rideable->id}}/Pulled"><i class="material-icons">store</i></a> --}}
@endif
