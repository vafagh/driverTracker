<ul class="list-group" id='truck'>
    @foreach ($trucks as $key => $truck)
        <li class="list-group-item disabled py-2 active font-weight-bold">{{$truck->lable}}</li>
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
                <div class='col-3'>
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
                </div>
        </li>
    @endforeach
</ul>
