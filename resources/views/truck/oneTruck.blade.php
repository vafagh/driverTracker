<li class="list-group-item disabled py-2 active font-weight-bold">
    <a class="text-white" href="/truck/show/{{$truck->id}}">{{$truck->lable}}</a>
</li>
<li class="row m-0 p-0 mb-1 border  border-secondary">
        <div class="col-4">
            Plate# {{$truck->license_plate}}<br>
            Gas card: {{$truck->gas_card}}
        </div>

        <div class='col-2'>
            Tank: {{$truck->tank_capacity}}<br>
            Mileage: {{$truck->mileage}}
        </div>
        <div class='col-3'>
            VIN#: {{$truck->last4vin}}<br>
            Total Trip: {{$truck->tank_capacity+65000}}
        </div>
        <div class='col-3 pt-2'>
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
            <a class="badge badge-info" href="/truck/show/{{$truck->id}}">Details</a>
        </div>
</li>
