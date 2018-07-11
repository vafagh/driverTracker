<li class="list-group-item row m-0 p-0">
    <div class="row m-0 p-0">

        <div class='locationName col-3'>{{$rideable->id}},{{ data_get($rideable->locations->first(),'name')}}</div>
        <div class='InvoiceNumber col-2'>#{{$rideable->invoice_number}}</div>
        <div class='InvoiceNumber col-2'>{{$rideable->status}}</div>
        <div class="col-5 row p-0 m-0">
            @foreach ($rideable->trucks as $truck)
                @foreach ($truck->drivers as $driver)
                    <div class='driver col-3'>{{$driver->fname}}</div>
                    <div class="orderCreated col-4"><span title="{{$rideable->created_at}}">{{ $rideable->created_at->diffForHumans()}}</span></div>
                    <div class="truckCreated col-5"><span title="{{$truck->pivot->created_at}}">{{ $truck->pivot->created_at->diffForHumans()}}</span></div>
                @endforeach
            @endforeach
        </div>
    </div>
</li>
