@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-light">
            <div class="col-10 h3">Users</div>
            <div class="col-2">
                @component('layouts.components.modal',[
                    'modelName'=>'user',
                    'action'=>'create',
                    'object'=>null,
                    'op1'=>'op1',
                    'op2'=>'user',
                    'iterator'=>0,
                    'file'=>true])
                @endcomponent
            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{$user->id}}</td>

                            <td>@component('layouts.components.tooltip',['modelName'=>'user','model'=>$user])@endcomponent</td>

                            <td>{{$user->email}}</td>
                            <td>{{$user->role_id}}</td>
                            <td><span title="{{$user->created_at}}">{{$user->created_at->diffForHumans()}}</span></td>
                            <td><span title="{{$user->updated_at}}">{{$user->updated_at->diffForHumans()}}</span></td>
                            <td>
                                @if (Auth::user()->role_id > 3)
                                    @component('layouts.components.modal',[
                                        'modelName'=>'user',
                                        'action'=>'edit',
                                        'iterator'=>$key,
                                        'object'=>$user,
                                        'btnSize'=>'small',
                                        'op1'=>'',
                                        'op2'=>'',
                                        'style'=>'badge badge-warning',
                                        'file'=>true])
                                    @endcomponent
                                    <a class="badge badge-danger" href="/user/delete/{{$user->id}}"> Delete</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h5 class="mx-4">Activity:</h5>
        <div class="card-body p-0">

            <div class="pagination">
                {{ $transactions->links("pagination::bootstrap-4") }}
            </div>
            <div class="header row m-0">
                <div class="col-4 col-sm-2 col-md-2 col-lg-2">By</div>
                <div class="col-5 col-sm-3 col-md-3 col-lg-2">Table</div>
                <div class="col-3 col-sm-2 col-md-1 col-lg-2">Row</div>
                <div class="col-4 col-sm-3 col-md-3 col-lg-4">Action</div>
                <div class="col-8 col-sm-2 col-md-3 col-lg-2">Create</div>
            </div>
            <div id="accordion">
                @foreach ($transactions as $key => $transaction)
                    <div class="card mb-1">
                        <div class="card-header" id="heading{{$key}}">
                                <div class="h5 my-0 row" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                    <a    class="col-4 col-sm-4 col-md-4 col-lg-2" href="/user/show/{{$transaction->user_id}}">{{$transaction->user->name}}</a>
                                    <a    class="col-4 col-sm-3 col-md-3 col-lg-2" href="/{{$transaction->table_name}}">{{$transaction->table_name}}</a>
                                    <a    class="col-4 col-sm-5 col-md-5 col-lg-2" href="/{{str_singular($transaction->table_name)}}/show/{{$transaction->row_id}}">{{$transaction->row_id}}</a>
                                    <span class="col-5 col-sm-5 col-md-5 col-lg-2 {{($transaction->action=='destroy') ? 'text-danger':''}}">{{$transaction->action}}</span>
                                    <span class="col-6 col-sm-6 col-md-6 col-lg-3" title="{{$transaction->created_at}}">{{$transaction->created_at->diffForHumans()}}</span>
                                    <i    class="col-1 folding more material-icons">unfold_more</i>
                                    <i    class="col-1 folding less material-icons">unfold_less</i>
                                </div>
                        </div>
                        <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                            <div class="card-body">
                                <div class="text-danger">
                                    @component('layouts.row',['data' =>$transaction->last_data])
                                    @endcomponent
                                </div>
                                <div class="text-success">
                                    @component('layouts.row',['data' =>$transaction->new_data])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination">
                {{ $transactions->links("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
@endsection
