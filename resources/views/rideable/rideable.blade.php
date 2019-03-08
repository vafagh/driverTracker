<ul class="deliveries list-group p-0" id='deliveries'>
    <li class=" d-flex justify-content-between m-0 py-1 bg-primary text-white rounded-top">
        <div cxlass="col-6 col-md-9 col-lg-6">
            <h3 class="m-0 p-0 pl-2">{{$op2}}</h3>
        </div>

        <div>
            <div class="d-none d-sm-inline btn-group" role="group">
                <button id="filterlist" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i title="Filter" class="material-icons">filter_list</i>
                </button>
                <div class="dropdown-menu" aria-labelledby="filterlist">
                    <a class="dropdown-item" href="?shift=first">First</a>
                    <a class="dropdown-item" href="?shift=second">Second</a>
                    <a class="dropdown-item" href="?shift=tomarow">Tomarow</a>
                    <a class="dropdown-item" href="?shift=all">All</a>
                </div>
            </div>

            <div class="btn-group" role="group">
                <button id="sortList" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i title="Sort" class="material-icons">sort</i>
                </button>
                <div class="dropdown-menu" aria-labelledby="sortList">
                    <a class="dropdown-item" href="?sortby=invoice_number">#</a>
                    <a class="dropdown-item" href="?sortby=location_id">Location</a>
                    <a class="dropdown-item" href="?sortby=created_at">Date</a>
                    <a class="dropdown-item" href="?sortby=updated_at">Update</a>
                    <a class="dropdown-item" href="?sortby=status">Status</a>
                    <a class="dropdown-item" href="?sortby=user_id">User</a>
                </div>
            </div>

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
        <div class="col-5  col-sm-3  col-md-2 col-lg-2              col-xl-1 ">
            location
        </div>
        <div class=" col-7  col-sm-6  col-md-3 col-lg-3              col-xl-3 ">
            {{($op1=='Client') ? 'Invoice': 'Part'}}#
        </div>
    </li>

    @foreach ($collection as $key => $rideable)
        <li class="list-group-item row m-0 p-0 {{$rideable->status}}" id="rideable{{$rideable->id}}">
            <div class="row m-0 p-0 py-2 h-100" {{($flashId==$rideable->id)? 'id="flash"':''}}>
                <div class='location        col-5  col-sm-2  col-md-2 col-lg-2              col-xl-2 pl-1 pr-1 text-truncate'>
                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$rideable->location])
                    @endcomponent
                </div>

                <div class='InvoiceNum      col-7  col-sm-3  col-md-3 col-lg-3              col-xl-3 p-0 text-truncate'>
                    @if (Auth::user()->role_id > 3 || Auth::user()->id == $rideable->user_id )
                        <div class="d-inline">
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

                <div class="user d-none d-sm-none d-md-none  col-md-3 d-lg-none d-xl-inline col-xl-1 text-secondary text-truncate"
                    title="{{$rideable->created_at}} {{ $rideable->created_at->diffForHumans()}}">
                    {{-- @if (Auth::user()->role_id > 4)
                        @component('layouts.components.tooltip',['modelName'=>'user','model'=>$rideable->user])
                        @endcomponent
                    @else --}}
                        by <strong>{{$rideable->user->name}}</strong>
                    {{-- @endif --}}
                    {{-- <span ></span> --}}
                </div>

                <div class='status          col-4  col-sm-2  col-md-2 col-lg-2              col-xl-1 p-0 text-truncate'>
                    <strong title="{{$rideable->updated_at}} {{ $rideable->updated_at->diffForHumans()}}">{{$rideable->status}}</strong>
                </div>

                <div class="row             col-6  col-sm-4  col-md-4 col-lg-4              col-xl-4  m-0 p-0 text-truncate ">
                    <div class="actions     col-12 col-sm-4 col-md-4  col-lg-4              col-xl-4 p-0 text-truncate">
                        @component('layouts.action',[
                            'action' => $rideable->status,
                            'rideable' => $rideable,
                            'object' => $rideable,
                            'iterator' => $key,
                            'op1'=>$op1,
                            'op2'=>$op2])
                        @endcomponent
                    </div>
                    <div class='delivery    col-12 col-sm-8 col-md-8  col-lg-8              col-xl-8 p-0'>
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

                @foreach ($rideable->rides as $ride)
                    <div class='driver      col-1                    col-lg-1 text-truncate' title="{{$ride->driver->fname}}" style="min-width:44px;background-size:35px; background-image: url(/img/driver/{{$ride->driver->image}}); background-position: right top, left top; background-repeat: no-repeat;">
                        @if (Auth::user()->role_id > 2  && $loop->last && $rideable->status != 'Done'  )
                            <a class="text-danger" href="/ride/detach/{{$ride ->id}}/{{$rideable->id}}">
                                <i class="material-icons md-16">remove_circle_outline</i>
                            </a>
                        @endif
                    </div>
                @endforeach

            </div>
        </li>
    @endforeach
    <div class="pagination">
        {{ $collection->links("pagination::bootstrap-4") }}
    </div>
</ul>
