<div class="card-body">
    <div class="card-body p-0">
        <table class="table table-compact">
            <thead>
                <tr>
                    <th>Invoice#</th>
                    <th>Action</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Truck</th>
                    <th>Schaduled for</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ongoingRides as $key => $ride)
                    <tr>
                        <td class='pl-2 fixedWidthFont font-weight-bold h4 '>
                            <a title="Cleck to view ticket detailes in new window" target="_blank" class="text-primary" href="/rideable/show/{{$ride->rideable->id}}">
                                {{$ride->rideable->invoice_number}}
                            </a>
                        </td>
                        @if (!empty($ride->rideable))
                        <td class="invoice">
                            @if (Auth::user()->role_id > 3 && $ride->rideable->status!='Done' && $ride->rideable->status!='Returned' && $ride->rideable->status!='Return' && $ride->rideable->status!='Reschedule')
                                <a title="Part " class="text-primary  " href="/rideable/{{$ride->rideable->id}}/Done"><i class="material-icons md-16">thumb_up</i></a>
                            @endif

                            @if (   Auth::user()->role_id >= 3
                                    && $ride->rideable != null
                                    && $ride->rideable->status!='Done'
                                    && $ride->rideable->status!='Returned' &&
                                    $ride->rideable->status!='Return'
                                )
                                {{-- @component('layouts.components.modal',['modelName'=>'rideable','action'=>'edit','dingbats'=>'<i class="material-icons md-14">edit</i>','style'=>'text-warning mr-1 float-left','iterator'=>$key,'object'=>$ride->rideable,'op1'=>$ride->rideable->type,'op2'=>'','file'=>false,'autocomplateOff'=>true])
                                @endcomponent --}}

                                @component('layouts.components.modal',['modelName'=>'status','action'=>'edit','dingbats'=>'<i class="material-icons md-16">thumb_down</i>','style'=>'text-danger mr-1 float-left','iterator'=>$key,'object'=>$ride->rideable,'op1'=>$ride->rideable->type,'op2'=>'','file'=>false,'autocomplateOff'=>true])
                                @endcomponent


                            @endif

                            @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$ride->rideable])
                            @endcomponent
                        </td>
                        <td class="location text-truncate">
                            @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])
                            @endcomponent
                        </td>
                        <td>{{$ride->rideable->status}}</td>
                        @else
                        <td colspan="3">
                            The ticket is deleted.
                            @if (Auth::user()->role_id>3)
                                <a href="/ride/delete/{{$ride->id}}">remove this line</a>
                            @endif
                        </td>
                        @endif
                        <td>
                            @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])
                            @endcomponent
                        </td>
                        <td>
                            <div title="{{$ride->created_at->diffForHumans()}}">
                                @if(!empty($ride->rideable) && $ride->rideable->location->type != 'DropOff' && $ride->rideable->delivery_date!=null)
                                    <span title="{{$ride->rideable->delivery_date.' '.$ride->rideable->shift}}">
                                        <i class="material-icons small">send</i>
                                        @if(App\User::setting('humanDate') && Auth::user()->role_id!=3)
                                            {{ App\Helper::dateName($ride->rideable->delivery_date)}}
                                        @else
                                            {{$ride->rideable->delivery_date}}
                                        @endif
                                        <i class="material-icons small">schedule</i>
                                        <span class="text-muted font-weight-light">{{ $ride->rideable->shift}}</span>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if ($finishedRides)
                    <tr class="table-dangers ">
                        <td colspan="7 bg-black">
                            <div class="d-inline-block pagination-sm">
                                {{ $finishedRides->links("pagination::bootstrap-4") }}
                            </div>
                        </td>
                    </tr>
                    @foreach ($finishedRides as $key => $ride)
                        <tr class="{{$ride->rideable->status}}">
                            <td class='pl-2'>{{$ride->id}}</td>
                            @if (!empty($ride->rideable))
                                <td class="location text-truncate">
                                    @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])
                                    @endcomponent
                                </td>
                                <td class="invoice fixedWidthFont font-weight-bold h4 minw-200">
                                    @component('layouts.components.tooltip',['modelName'=>'rideable','model'=>$ride->rideable])
                                    @endcomponent
                                </td>
                                <td>{{$ride->rideable->status}}</td>
                            @else
                                <td class='no-info' colspan="3">
                                    The ticket is deleted.
                                    @if (Auth::user()->role_id>3)
                                        <a href="/ride/delete/{{$ride->id}}">remove this line</a>
                                    @endif
                                </td>
                            @endif
                            <td class="truck text-truncate">
                                @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])
                                @endcomponent
                            </td>
                            <td>
                                <div title="{{$ride->created_at->diffForHumans()}}">
                                    @if(!empty($ride->rideable) && $ride->rideable->location->type != 'DropOff' && $ride->rideable->delivery_date!=null)
                                        <span title="{{$ride->rideable->delivery_date.' '.$ride->rideable->shift}}">
                                            <i class="material-icons small">send</i>
                                            @if(App\User::setting('humanDate') && Auth::user()->role_id!=3)
                                                {{ App\Helper::dateName($ride->rideable->delivery_date)}}
                                            @else
                                                {{$ride->rideable->delivery_date}}
                                            @endif
                                            <i class="material-icons small">schedule</i>
                                            <span class="text-muted font-weight-light">{{ $ride->rideable->shift}}</span>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">
                            <div class="pagination">
                                {{ $finishedRides->links("pagination::bootstrap-4") }}
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
