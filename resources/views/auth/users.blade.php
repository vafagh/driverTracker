@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-white">
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
                        <th>Role</th>>
                        <th>Updated At</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            {{--
                            <td>
                                 @if ($user->image!='')
                                    @component('layouts.components.imgtooltip',['modelName'=>'user','model'=>$user])@endcomponent
                                @endif
                            </td>
                             --}}
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
                                        'file'=>true
                                    ])
                                    @endcomponent
                                    <a class="badge badge-danger" href="/user/delete/{{$user->id}}"> Delete</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
