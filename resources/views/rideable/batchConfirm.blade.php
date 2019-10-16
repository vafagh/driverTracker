@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-header row m-0 h4 bg-primary text-light">
            <span class="col-10">
                Batch import
            </span>

        </div>
        <div class="card-body">

            <div class="row ">
                <div class="col-2 ">Invoice Number</div>
                <div class="col-2 ">Invoiced on / Deliver for</div>
                <div class="col-4  row p-0 m-0">
                    <div class="col-12 text-center">Shifts</div>
                    {{-- <div class="col-4">Morning</div>
                    <div class="col-4">Evening</div>
                    <div class="col-4">Not Clear</div> --}}
                </div>
                <div class="col-2 ">Customer Name</div>
                <div class="col-2 ">Invoice total</div>
            </div>
            @if ($invoices!=Null)
                <form enctype="multipart/form-data"  method="POST" action="/rideable/store">
                    @foreach ($invoices as $key => $invoice)
                        @php
                            $location = App\Location::where('name', '=', $invoice[2])->get();
                            $returnedRideable = App\Rideable::where('invoice_number', '=', $invoice[0])->get();
                            $rideable = $returnedRideable->first();
                            $date = explode("/",$invoice[1]);
                            $when=App\Helper::when(null);
                            $invoice_date = App\Helper::dateName('20'.$date[2].'-'.$date[0].'-'.$date[1]);
                            $delivery_date = $when['date'];
                            $shift = $when['shift'];
                        @endphp

                        @if ($returnedRideable->count()==0)
                            @php
                                if($location->count() == 1){
                                    $propertyName = 'name';
                                    $n++;
                                }
                                else
                                $propertyName = 'data-toggle';
                            @endphp
                            <div class="row mb-2 {{($propertyName=="data-toggle")?'op-03':''}}">
                                <div   class="col-2 input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="item_{{$n}}" {{($location->count() == 0)? 'disabled': 'checked'}}>
                                        </div>
                                    </div>
                                    <input class="form-control " {{$propertyName}}="invoice_number{{$n}}" value="{{$invoice[0]}}">
                                </div>
                                <div class="row col-3 m-0">
                                    <input class="col-6" value="{{$invoice_date}}" disabled>
                                    <input class="col-6" {{$propertyName}}="delivery_date{{$n}}" value="{{$delivery_date}}">
                                    @if ($invoice_date==$delivery_date)
                                        <input class="col-2 " {{$propertyName}}="delivery_date{{$n}}" value="{{$delivery_date}}">
                                    @else
                                    @endif
                                </div>

                                <div   class="row col-4 m-0 ">
                                    <div class="col-4 form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" {{$propertyName}}="shift{{$n}}" id="{{$propertyName}}Morning{{$n}}{{$invoice[0]}}" value='Morning' {{($shift=="Morning")?'checked':''}} {{($propertyName=="data-toggle")?'disabled':''}}>
                                        <label class="form-check-label" for="{{$propertyName}}Morning{{$n.$invoice[0]}}" title="Morning">Morning</label>
                                    </div>
                                    <div class="col-4 form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" {{$propertyName}}="shift{{$n}}" id="{{$propertyName}}Evening{{$n}}{{$invoice[0]}}" value='Evening' {{($shift=="Evening")?'checked':''}} {{($propertyName=="data-toggle")?'disabled':''}}>
                                        <label class="form-check-label" for="{{$propertyName}}Evening{{$n.$invoice[0]}}" title="Evening">Evening</label>
                                    </div>
                                    <div class="col-4 form-check form-check-inline m-0">
                                        <input class="form-check-input" type="radio" {{$propertyName}}="shift{{$n}}" id="{{$propertyName}}Notclear{{$n}}{{$invoice[0]}}" value='Pickup' {{($propertyName=="data-toggle")?'disabled':''}}>
                                        <label class="form-check-label" for="{{$propertyName}}Notclear{{$n}}{{$invoice[0]}}">Pickup</label>
                                    </div>
                                </div>
                                <input class="col-2  {{($location->count() == 0)? 'bg-danger': 'bg-success'}}" {{$propertyName}}="locationName{{$n}}" value="{{$invoice[2]}}">
                                <span class="col-1 {{$invoice[4]<=0 ? 'text-danger':''}}" >{{$invoice[4]}}</span>
                            </div>
                        @else
                            {{-- <div class="row mb-2"><input class="col-2 ml-1 {{($returnedRideable->count()>0)?'bg-success':''}}"  value="{{$invoice[0]}}"><input class="col-2 ml-1 " value="{{$delivery_date}}"><input class="col-2 ml-1 {{($location->count() == 0)? 'bg-danger': 'bg-success'}}"  value="{{$invoice[2]}}"><input class="col-2 ml-1 "  placeholder="enter phone" {{($location->count() == 0)? 'required': ''}} ><input class="col-2 ml-1 " value="{{$invoice[4]}}"></div> --}}

                            <div class="row m-0 p-0 h-100 pt-1" >
                                <div class='InvoiceNum      col-7  col-sm-3 col-md-3 col-lg-3    col-xl-3 p-0 text-truncate '>
                                    <div class="InvoiceNumber fixedWidthFont d-inline">
                                        @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$rideable])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class='status          col-4  col-sm-2 col-md-2 col-lg-2    col-xl-1 p-0 text-truncate line'>
                                    <strong class="hideOnHover" title="{{$rideable->updated_at}} {{ $rideable->updated_at->diffForHumans()}}">{{$rideable->status}}</strong>
                                    <strong class="showOnHover">{{$rideable->updated_at}}</strong>
                                </div>
                                <div class='location        col-5  col-sm-2 col-md-2 col-lg-2    col-xl-2 pl-2 pr-1 text-truncate'>
                                    <a class="text-dark" href="/location/show/{{$rideable->location->id}}">
                                        {{$rideable->location->longName}}
                                    </a>
                                </div>
                                <div class="user            d-none d-sm-none d-md-none d-lg-none col-xl-1 d-xl-inline text-secondary text-truncate line" title=" {{ $rideable->created_at->diffForHumans()}}">
                                    <strong class="hideOnHover">{{$rideable->user->name}}</strong>
                                    <strong class="showOnHover">{{$rideable->created_at}}</strong>
                                </div>
                                <div class="row             col-6  col-sm-4 col-md-4 col-lg-4    col-xl-4 m-0 p-0 text-truncate">
                                    <div class="actions     col-12 col-sm-4 col-md-4 col-lg-4    col-xl-4 p-0 text-truncate">
                                        {{--@component('layouts.action',['action' => $rideable->status,'rideable' => $rideable,'object' => $rideable,'iterator' => $key,'op1'=>'Client','op2'=>'Delivery'])@endcomponent--}}
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
                                            @if (Auth::user()->role_id > 3  && $loop->last && $rideable->status != 'Done' &&  $rideable->status != 'Reschedule' )
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
                    <input type="hidden" name="rawData" value="{{$rawData}}">
                    <input type="hidden" name="type" value="Delivery">
                    <input type="hidden" name="n" value="{{$n}}">
                    <input type="hidden" name="redirect" value="back">
                    <input type="hidden" name="submitType" value="batch">
                     <div class="">
                         {{$n}} Ticket is available to add
                     </div>
                     <div class="">
                         <button type="submit" class="btn btn-primary ">Add selected line</button>
                     </div>
                    {{ csrf_field() }}
                </form>
            @endif
            <div class="card-footer mt-4">
                <form method="POST" action="/rideable/batch" class="border p-3 text-center">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="rawtext">Raw data:</label>
                        </div>
                        <div class="form-group ">
                            <textarea class="fixedWidthFont px-4 m-auto" id="rawtext" name="rawData" cols="78" rows="{{(!empty($invoices))?count($invoices):'10'}}">{{$rawData}}</textarea>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                </form>
            </div>
        </div>
    </div>
@endsection
