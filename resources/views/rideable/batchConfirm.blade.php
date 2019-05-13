@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-header row m-0 h4 bg-primary text-light">
            <span class="col-10">
                Batch add
            </span>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-2">Invoice Number</div>
                <div class="col-2">Invoice Date</div>
                <div class="col-2"> Customer Number</div>
                <div class="col-2"> Customer Name</div>
                <div class="col-2"> Invoice total</div>
            </div>
            @if ($invoices!=Null)

                @foreach ($invoices as $key => $invoice)
                    @php
                    // dd(gettype($invoice));
                    $location = App\Location::where('name', '=', $invoice[2])->get();
                    $returnedRideable = App\Rideable::where('invoice_number', '=', $invoice[0])->get();
                    $rideable = $returnedRideable->first();
                    $date = explode("/",$invoice[1]);
                    $delivery_date = '20'.$date[2].'/'.$date[0].'/'.$date[1];
                    @endphp

                    @if ($returnedRideable->count()==0)
                        <div class="row mb-2">
                            <form  enctype="multipart/form-data"  method="POST" action="/rideable/store" method="post">
                                <input class="col-2 ml-1 " name="invoice_number0" value="{{$invoice[0]}}">
                                <input class="col-2 ml-1 " name="delivery_date" value="{{$delivery_date}}">
                                <input class="col-2 ml-1 {{($location->count() == 0)? 'bg-danger': 'bg-success'}}" name="locationName" value={{$invoice[2]}}>
                                <input class="col-2 ml-1 " name="phone" placeholder="enter phone" {{($location->count() == 0)? 'required': ''}} >
                                <input class="col-2 ml-1 " name="total" value="{{$invoice[4]}}">
                                <input type="hidden" name="rawData" value="{{$rawData}}">
                                <input type="hidden" name="redirect" value="back">
                                <input type="hidden" name="submitType" value="batch">
                                <button type="submit"  {{($location->count() == 0)? 'disabled class=btn-secondary': 'class=btn btn-primary'}}>Confirm</button>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    @else

                        <div class="row m-0 p-0 h-100 pt-1" >
                            <div class='location        col-5  col-sm-2 col-md-2 col-lg-2    col-xl-2 pl-2 pr-1 text-truncate'>
                                <a class="text-dark" href="/location/show/{{$rideable->location->id}}">
                                    {{$rideable->location->longName}}
                                </a>
                            </div>
                            <div class='InvoiceNum      col-7  col-sm-3 col-md-3 col-lg-3    col-xl-3 p-0 text-truncate '>
                                @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                                    <div class=" d-inline  ">
                                        @component('layouts.components.modal',[
                                            'modelName'=>'rideable',
                                            'action'=>'edit',
                                            'dingbats'=>'<i class="material-icons md-16">edit</i>',
                                            'style'=>'text-info pr-0',
                                            'iterator'=>$key,
                                            'object'=>$rideable,
                                            'op1'=>'Client',
                                            'op2'=>'Delivery',
                                            'file'=>false,
                                            'autocomplateOff'=>true])
                                        @endcomponent
                                    </div>
                                @endif
                                <div class="InvoiceNumber fixedWidthFont d-inline">
                                    @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                    @endcomponent
                                </div>
                            </div>
                            <div class="user            d-none d-sm-none d-md-none d-lg-none col-xl-1 d-xl-inline text-secondary text-truncate line" title=" {{ $rideable->created_at->diffForHumans()}}">
                                <strong class="hideOnHover">{{$rideable->user->name}}</strong>
                                <strong class="showOnHover">{{$rideable->created_at}}</strong>
                            </div>
                            <div class='status          col-4  col-sm-2 col-md-2 col-lg-2    col-xl-1 p-0 text-truncate line'>
                                <strong class="hideOnHover" title="{{$rideable->updated_at}} {{ $rideable->updated_at->diffForHumans()}}">{{$rideable->status}}</strong>
                                <strong class="showOnHover">{{$rideable->updated_at}}</strong>
                            </div>

                            <div class="row             col-6  col-sm-4 col-md-4 col-lg-4    col-xl-4 m-0 p-0 text-truncate">
                                <div class="actions     col-12 col-sm-4 col-md-4 col-lg-4    col-xl-4 p-0 text-truncate">
                                    @component('layouts.action',[
                                        'action' => $rideable->status,
                                        'rideable' => $rideable,
                                        'object' => $rideable,
                                        'iterator' => $key,
                                        'op1'=>'Client',
                                        'op2'=>'Delivery'])
                                    @endcomponent
                                </div>
                                <div class='delivery    col-12 col-sm-8 col-md-8 col-lg-8    col-xl-8 p-0'>
                                    @if($rideable->location->type != 'DropOff' && $rideable->delivery_date!=null)
                                        <span title="{{$rideable->delivery_date.' '.$rideable->shift}}">
                                            <i class="material-icons small">send</i>
                                            {{ App\Helper::dateName($rideable->delivery_date)}}
                                            <i class="material-icons small">schedule</i>
                                            {{ $rideable->shift}}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class='driver row      col-1                    col-lg-1 text-truncate p-0'>
                                @foreach ($rideable->rides as $ride)
                                    <div class='line col-{{12/($rideable->rides->count())}} p-0 text-right'>
                                        <img class="NOhideOnHover icon position-relative"  title='{{$ride->driver->fname}}' src="/img/driver/small/{{strtolower($ride->driver->fname)}}.png">
                                        @if (Auth::user()->role_id > 3  && $loop->last && $rideable->status != 'Done' &&  $rideable->status != 'Reschadule' )
                                            <a class="showOnHover text-danger position-relative" title='Remove {{$ride->driver->fname}}' href="/ride/detach/{{$ride ->id}}/{{$rideable->id}}">
                                                <i class="material-icons md-16">remove_circle_outline</i>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif
                @endforeach
            @endif
            <div class="card-footer">

                <form method="POST" action="/rideable/batch">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Your raw data:</label>
                        <textarea class="form-control" id="message-text" name="rawData" cols="100">{{$rawData}}</textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    @endsection
