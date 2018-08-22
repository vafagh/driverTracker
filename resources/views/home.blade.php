@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            @component('rideable.rideable',['collection'=> $deliveries,'op1'=>'Client','op2'=>'Delivery','flashId'=>$flashId])
                File Missing!
            @endcomponent
            <hr>
            @component('rideable.rideable',['collection'=> $pickups,'op1'=>'Warehouse','op2'=>'Pickup','flashId'=>$flashId])
                File Missing!
            @endcomponent
        </div>
    </div>
    <div class="card-deck mt-3 px-2">
        @foreach ($warehouses as $key => $warehouse)
            <div class="card mx-1">
                <div class="text-center mh-50">
                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$warehouse])@endcomponent
                </div>

                <div class="card-body px-1">

                    <p class="card-text">
                        <small class="text-muted">
                            Total trip :{{ App\Rideable::where('location_id', $warehouse->id)->count() }}
                        </small>
                        @foreach (App\Rideable::where([
                                ['status','!=','Done'],
                                ['status','!=','Canceled'],
                                ['status','!=','Delete'],
                                ['location_id',$warehouse->id]
                            ])->get() as $key => $value)
                            <div class="fixedWidthFont">
                                {{$value->invoice_number}}
                            </div class="fixedWidthFont">

                        @endforeach
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
