<li class="list-group-item row m-0 p-0">
    <div class="row m-0 p-0">
        <div class="col-6 row m-0">
            <div class='locationName col-5' title="{{$rideable->user->name}}">{{ $rideable->location->name}}</div>
            <div class='InvoiceNumber col-3'>#{{$rideable->invoice_number}}</div>
            <div class='InvoiceNumber col-4'>
                {{$rideable->status}}<br>
                @component('layouts.action',['action' => $rideable->status])@endcomponent</div>
        </div>
        <div class="col-6 row m-0">
            @foreach ($rideable->rides as $ride)
                <div class='driver col-3'>{{$ride->driver->fname}}</div>
                <div class='driver col-3'>{{$ride->truck->license_plate}}</div>
                <div class="orderCreated col-3"><span title="{{$rideable->created_at}}">{{ $rideable->created_at->diffForHumans()}}</span></div>
                <div class="truckCreated col-3"><span title="{{$ride->pivot->created_at}}">{{ $ride->pivot->created_at->diffForHumans()}}</span></div>
            @endforeach

        </div>
    </div>
</li>
