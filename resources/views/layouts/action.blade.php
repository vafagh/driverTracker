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
    $detach         = false;
    $return         = false;
    $reschedule     = false;
    $pulled         = false;
    $noData         = false;

if ($user_role > 0 ){
    switch($action){
        case 'Created':
            $delete = true;
            $pulled = true;
            $assignDriver = true;
            $notAvailable = true;
            if ($rideable->location->type  == 'DropOff') {
                $done = true;
            }
            $doneAtach = true;
            $noData = true;
        break;

        case 'Returned':
            if ($user_role >3){
                $done = true;
                $reschedule = true;
            }
        break;

        case 'DriverDetached':
            $noData = true;
            if ($user_id == $rideable->user_id) $delete = true;
            ($rideable->location->type  == 'Client') ?$assignDriver = true : $done = true;
            $pulled = true;
        break;

        case 'Reschedule':
            ($user_id == $rideable->user_id) ? $delete = true : "";
            ($rideable->location->type != 'DropOff') ?$assignDriver = true : "";
            $done = true;
        break;

        case 'OnTheWay':
            ($title != 'Delivered' || $rideable->location->type != 'Client') ? $notAvailable = true : $return = true;
            $detach = true;
            $done = true;
            $doneAtach = true;
        break;

        case 'DeatachReqested':
            if ($user_role > 3)
                $done = true;
        break;

        case 'NotAvailable':
                $clear = true;
        break;

        case 'Double Entry':
            $delete = true;
        break;

        default :
        if (Auth::user()->role_id > 4){
            $reschedule = true;
            $done = true;
            $notAvailable = true;
            $detach = true;
            $assignDriver = true;
            $delete = true;
            $pulled = true;
            }
    }
}

@endphp

@if ($delete && ($user_id == $rideable->user_id  || $user_role >= 5))
    <a title="Cancel" class="text-danger" href="/rideable/delete/{{$rideable->id}}/"><i class="material-icons">delete_forever</i></a>
@endif
@if ($assignDriver && $rideable->location->type == 'Client' && ($rideable->location->name != 'IND' || $rideable->location->name != 'Online') && $user_role >= 3)
    @component('layouts.components.modal',['modelName'=>'ride','action'=>'create','iterator'=>$rideable->id,'object'=>$rideable,'btnSize'=>'small','style'=>'text-info text-white ','op1'=>'','op2'=>'','dingbats'=>'<i class="material-icons">drive_eta</i> ','file'=>false])
    @endcomponent
@endif
@if ($done  && $user_role > 2)
    <a class=" showOnHover" href="/rideable/{{$rideable->id}}/Done"><i class="material-icons">done</i></a>
@endif
@if ($doneAtach && !empty($rideable->location->driver_id) && $rideable->location->type == 'Warehouse' && $user_role > 2 && !empty(App\Driver::find($rideable->location->driver_id)->truck_id))
    <a class="text-primary" title="Attach and Done" href='/ride/store/{{$rideable->id}}/{{$rideable->location->driver_id}}/Done'><i class="material-icons">done_outline</i></a>
@endif
@if ($clear && $user_role >= 3)
    <a title="Clear line" class="text-danger" href="/rideable/{{$rideable->id}}/Canceled">
        <i class="material-icons">clear_all</i>
    </a>
@endif
@if ($noData && $user_role >= 3 && ($count = App\Transaction::where('table_name','=','rideables')->where('row_id','=',$rideable->id)->count()) > 3)
    <a title="{{$count}} attempt." class="text-secondary" href="/rideable/{{$rideable->id}}/NoData">
        <i class="material-icons">wifi_off</i>
    </a>
@endif
@if ($notAvailable && $rideable->location->type == 'Warehouse')
    <a title="Parts not available" class="text-danger showOnHover" href="/rideable/{{$rideable->id}}/NotAvailable"><i class="material-icons">priority_high</i></a>
@endif
@if ($return && $user_role >= 3)
    <a title="Returned" class=" showOnHover" href="/rideable/{{$rideable->id}}/Returned"><i class="material-icons">keyboard_return</i></a>
@endif
@if ($reschedule)
    <a class="text-primary showOnHover" title="Send driver back" href="/rideable/{{$rideable->id}}/Reschedule"><i class="material-icons">refresh</i></a>
@endif
@if ($pulled && $title =='Delivered')
    @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','iterator'=>$rideable->id,'object'=>$rideable,'btnSize'=>'small','style'=>'text-info text-white ','op1'=>'','op2'=>'','dingbats'=>'<i class="material-icons">store</i> ','file'=>false,'noneStatus'=>false])
    @endcomponent
    {{-- <a class="text-primary showOnHover" title="Picked up in store" href="/rideable/{{$rideable->id}}/Pulled"><i class="material-icons">store</i></a> --}}
@endif
@if ($detach && $user_role >= 3)
    @foreach ($rideable->rides as $ride)
        <div class='line  p-0 text-right d-inline tn5'>
            <img class="hideOnHover icon maxh-24" title='{{$ride->driver->fname}}' src="/img/driver/small/{{strtolower($ride->driver->fname)}}.png">
            @if (Auth::user()->role_id > 2  && $loop->last && $rideable->status != 'Done' &&  $rideable->status != 'Reschedule' )
                <a class="showOnHover text-danger position-relative pb-2 mb-2" title='Remove {{$ride->driver->fname}}' href="/ride/detach/{{$ride ->id}}/{{$rideable->id}}">
                    <i class="material-icons ">remove_circle_outline</i>
                </a>
            @endif
        </div>
    @endforeach
@endif
