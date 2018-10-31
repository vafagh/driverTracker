<li class="list-group-item disabled py-1 active font-weight-bold">
        <a class="text-white font-weight-bold" href="/truck/show/{{$truck->id}}">{{$truck->lable}}</a>
</li>
<li class="row m-0 p-0 mb-3 border  border-secondary">
        <div class="col-12 col-sm-2 col-md-1 col-lg-2">
            <a class="text-white font-weight-bold" href="/truck/show/{{$truck->id}}">
                <img class="w-100" src="/img/truck/{{($truck->image=='') ? 'truck.svg' : $truck->image}}" alt="truck image">
            </a>
        </div>
        <div class="col-12 col-sm-4 col-lg-4">
            <div>Plate# <strong>{{$truck->license_plate}}</strong></div>
            <div>Gas card: <strong>{{$truck->gas_card}}</strong></div>
            <div>Tank: <strong>{{$truck->tank_capacity}}</strong></div>
        </div>
        <div class='col-12 col-sm-4 col-lg-3'>
            <div>VIN#: <strong>{{$truck->last4vin}}</strong></div>
            <div>Mileage: <strong>{{$truck->mileage}}</strong></div>
            <div>Total Trip: <strong> - </strong></div>
        </div>
        <div class='col-12 col-sm-2  col-lg-2 p-0 pt-2'>
            @if (Auth::user()->role_id > 3)
                @component('layouts.components.modal',[
                    'modelName'=>'truck',
                    'action'=>'edit',
                    'op1'=>'op1',
                    'op2'=>'truck',
                    'object'=>$truck,
                    'style'=>'badge badge-warning',
                    'iterator'=>$key,
                    'file'=>true
                ])
                @endcomponent
                @component('layouts.components.modal',[
                    'modelName'=>'fillup',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'fillup',
                    'style'=>'badge badge-success',
                    'dingbats'=>'add gas',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
                @component('layouts.components.modal',[
                    'modelName'=>'service',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'service',
                    'style'=>'badge badge-info',
                    'dingbats'=>'add Service',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
                <a class="badge badge-success" href="/truck/show/{{$truck->id}}">Details</a>
            @endif
        </div>
</li>
