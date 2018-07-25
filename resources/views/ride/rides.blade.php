@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0">
            All Rides
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <td colspan="6">
                            <div class="pagination">
                                {{ $rides->links("pagination::bootstrap-4") }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>For</th>
                        <th>Driver</th>
                        <th>Truck</th>
                        <th>Create</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rides as $key => $ride)
                        <tr>
                            <td>{{$ride->id}}</td>
                            <td>
                                @component('layouts.components.tooltip',['modelName'=>'location','model'=>$ride->rideable->location])@endcomponent
                            </td>
                            <td>
                                @component('layouts.components.tooltip',['modelName'=>'driver','model'=>$ride->driver])@endcomponent
                            </td>
                            <td>
                                @component('layouts.components.tooltip',['modelName'=>'truck','model'=>$ride->truck])@endcomponent
                            </td>
                            <td><span title="{{$ride->created_at}}">{{$ride->created_at->diffForHumans()}}</span></td>
                            <td>
                                @component('layouts.components.modal',[
                                    'modelName'=>'ride',
                                    'action'=>'edit',
                                    'iterator'=>$key,
                                    'object'=>$ride,
                                    'btnSize'=>'small',
                                    'op1'=>'',
                                    'op2'=>''
                                ])
                                @endcomponent
                                <a class="badge badge-danger" href="/ride/delete/{{$ride->id}}"> Delete</a>

                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">
                            <div class="pagination">
                                {{ $rides->links("pagination::bootstrap-4") }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
