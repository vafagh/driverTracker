<li class="list-group-item disabled py-2 active font-weight-bold">
    <a class="text-white" href="/truck/show/{{$truck->id}}">{{$truck->lable}}</a>
</li>
<li class="row m-0 p-0 mb-1 border  border-secondary">
        <div class="col-3">
            <img class="w-75" src="/img/truck/{{($truck->image=='') ? 'truck.svg' : $truck->image}}" alt="truck image">
        </div>
        <div class="col-5">
            <div>Plate# <strong>{{$truck->license_plate}}</strong></div>
            <div>Gas card: <strong>{{$truck->gas_card}}</strong></div>
            <div>Tank: <strong>{{$truck->tank_capacity}}</strong></div>
            <div>Mileage: <strong>{{$truck->mileage}}</strong></div>
        </div>
        <div class='col-3'>
            <div>VIN#: <strong>{{$truck->last4vin}}</strong></div>
            <div>Total Trip: <strong> - </strong></div>
        </div>
        <div class='col-1 pt-2'>
            @component('layouts.components.modal',[
                'modelName'=>'truck',
                'action'=>'edit',
                'op1'=>'op1',
                'op2'=>'truck',
                'btnSize'=>'small',
                'object'=>$truck,
                'iterator'=>$key,
                'file'=>true
            ])
            @endcomponent
            <a class="badge badge-success" href="/truck/show/{{$truck->id}}">Details</a>
        </div>
</li>
