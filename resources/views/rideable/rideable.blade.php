<ul class="deliveries list-group p-0" id='deliveries'>
    <li class=" d-flex justify-content-between m-0 py-1 bg-primary text-white rounded-top">
        <div cxlass="col-6 col-md-9 col-lg-6">
            <div class=" m-0 p-0 pl-2">
                <span class="h3">
                    {{$op2}}
                </span>
                <span title="Number of lines" class='h6 badge badge-pill badge-warning align-top p-2 ml-1'>
                    {{$collection->count()}}
                </span>
            </div>
        </div>
            <div class="row m-0" >
                @if ($collection->count()>0)
                    {{-- @if (strstr(URL::full(),'delivery_date') && strstr(URL::full(),'shift')) --}}
                    @if (strstr(URL::full(),'delivery_date'))
                        <div class="batchUpdate d-none d-sm-inline btn-group" role="group">
                            <button id="filterlist" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i title="Filter" class="material-icons">play_for_work</i> Move all to
                            </button>
                            <div class="dropdown-menu" aria-labelledby="filterlist">
                                <a class="dropdown-item" href="{{strtolower($op2)}}/massUpdate{{str_replace(URL::current(),'',URL::full())}}&amp;newShift=Morning&amp;newDelivery_date={{\Carbon\Carbon::today()->toDateString()}}">Today Morning</a>
                                <a class="dropdown-item" href="{{strtolower($op2)}}/massUpdate{{str_replace(URL::current(),'',URL::full())}}&amp;newShift=Evening&amp;newDelivery_date={{\Carbon\Carbon::today()->toDateString()}}">Today Evening</a>
                            </div>
                        </div>
                    @endif
                @endif

                @if ($op2 == 'Delivery')
                    <div class="filter btn-group col" role="group">
                        <button id="filterlist" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i title="Filter" class="material-icons">filter_list</i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="filterlist">
                            <a class="dropdown-item" href="?shift=Morning&amp;delivery_date={{\Carbon\Carbon::yesterday()->toDateString()}}">Yesterday Morning</a>
                            <a class="dropdown-item" href="?shift=Evening&amp;delivery_date={{\Carbon\Carbon::yesterday()->toDateString()}}">Yesterday Evening</a>
                            <a class="dropdown-item" href="?shift=Morning&amp;delivery_date={{\Carbon\Carbon::today()->toDateString()}}">Today Morning</a>
                            <a class="dropdown-item" href="?shift=Evening&amp;delivery_date={{\Carbon\Carbon::today()->toDateString()}}">Today Evening</a>
                            <a class="dropdown-item" href="?shift=Morning&amp;delivery_date={{\Carbon\Carbon::tomorrow()->toDateString()}}">Tomorrow Morning</a>
                            <a class="dropdown-item" href="?shift=Evening&amp;delivery_date={{\Carbon\Carbon::tomorrow()->toDateString()}}">Tomorrow Evening</a>
                            <a class="dropdown-item" href="?delivery_date=all">All incomplete</a>
                            <a class="dropdown-item" href="?delivery_date=all&amp;status=returned">All Returned</a>
                        </div>
                    </div>
                @endif

                @component('layouts.components.modal',[
                    'modelName'=>'rideable',
                    'action'=>'create',
                    'iterator'=>0,
                    'object'=>null,
                    'op1'=>$op1,
                    'op2'=>$op2,
                    'dingbats'=>'<i class="material-icons">add_box</i>',
                    'autocomplateOff'=>true])
                @endcomponent
            </div>

    </li>

    <div class="pagination">
        {{ $collection->links("pagination::bootstrap-4") }}
    </div>

    <li class="row  m-0 p-0 {{$op2}} ">

        <div class="location col-5  col-sm-2  col-md-2 col-lg-2 col-xl-2 ">
            <a class="dropdown-item" href="{{str_replace(URL::current(),'',URL::full())}}&amp;sortby=location_id">Location</a>
        </div>

        <div class="InvoiceNum col-7  col-sm-3  col-md-3 col-lg-3 col-xl-3">
            <a class="dropdown-item" href="{{str_replace(URL::current(),'',str_replace('sortby=','oldSortby=',URL::full()))}}&amp;sortby=invoice_number">{{($op1=='Client') ? 'Invoice': 'Part'}}#</a>
        </div>

        <div class="user d-none d-sm-none d-md-none  col-md-3 d-lg-none d-xl-inline col-xl-1">
            <a class="dropdown-item" href="{{str_replace(URL::current(),'',URL::full())}}&amp;sortby=user_id">By</a>
        </div>

        <div class="status col-4  col-sm-2  col-md-2 col-lg-2 col-xl-1">
            <a class="dropdown-item" href="{{str_replace(URL::current(),'',URL::full())}}&amp;sortby=status">Status</a>
        </div>

        <div class="row col-6  col-sm-4  col-md-4 col-lg-4 col-xl-4">
            <div class="actions col-12 col-sm-4 col-md-4  col-lg-4 col-xl-4"><a class="dropdown-item" href="#">Action</a></div>
            <div class='delivery col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8'>
                <a class="dropdown-item" href="{{str_replace(URL::current(),'',URL::full())}}&amp;sortby=delivery_date">Delivery</a>
            </div>
        </div>

    </li>

    @foreach ($collection as $key => $rideable)
        <li class="list-group-item row m-0 p-0 {{$rideable->status}}" id="rideable{{$rideable->id}}">
            <div class="row m-0 p-0 h-100 pt-1" {{($flashId==$rideable->id)? 'id="flash"':''}}>
                <div class='location        col-5  col-sm-2 col-md-2 col-lg-2    col-xl-2 pl-2 pr-1 text-truncate'>{{-- @component('layouts.components.tooltip',['modelName'=>'location','model'=>$rideable->location]) @endcomponent --}}
                    <a class="text-dark" href="/location/show/{{$rideable->location->id}}">
                        @if (empty($rideable->location->image))
                            {{$rideable->location->longName}}
                        @else
                            <img  class="minh-30" src="/img/location/{{$rideable->location->image}}">
                        @endif
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
                                'op1'=>$rideable->type,
                                'op2'=>'',
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
                    {{-- @if (Auth::user()->role_id > 4)
                        @component('layouts.components.tooltip',['modelName'=>'user','model'=>$rideable->user])
                        @endcomponent
                    @else --}}
                        <strong class="hideOnHover">{{$rideable->user->name}}</strong>
                        <strong class="showOnHover">{{$rideable->created_at}}</strong>
                    {{-- @endif --}}
                    {{-- <span ></span> --}}
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
                            'op1'=>$op1,
                            'op2'=>$op2])
                        @endcomponent
                    </div>
                    <div class='delivery    col-12 col-sm-8 col-md-8 col-lg-8    col-xl-8 p-0'>
                        {{-- <span title="{{$rideable->updated_at}}">{{ $rideable->updated_at->diffForHumans()}}</span> --}}
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
                        @if (Auth::user()->role_id > 2  && $loop->last && $rideable->status != 'Done' &&  $rideable->status != 'Reschadule' )
                            <a class="showOnHover text-danger position-relative" title='Remove {{$ride->driver->fname}}' href="/ride/detach/{{$ride ->id}}/{{$rideable->id}}">
                                <i class="material-icons md-16">remove_circle_outline</i>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>

            </div>
        </li>
    @endforeach
    <div class="pagination">
        {{ $collection->links("pagination::bootstrap-4") }}
    </div>
</ul>
