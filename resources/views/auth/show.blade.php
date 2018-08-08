@extends('layouts.app')
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header row m-0">
                <div class="col-10">
                    User
                </div>
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
                <ul class="list-group" id='userd'>
                    <li class="row m-0 p-0 mb-1">
                        {{-- <img class="w-100" src="{{($user->image == null) ? '/img/def.svg' : '/img/user/'.$user->image }}" alt=""> --}}
                        <div class="col-4">
                            <div>Name: {{$user->name}}</div>
                            <div>Email: {{$user->email}}</div>
                            <div>Role: {{$user->role_id}}</div>
                        </div>
                        <div class="col-4">
                            Created at: {{$user->created_at}}<br>
                            Updated at: {{$user->updated_at}}
                        </div>
                        <div class="col-4 text-right pt-2">
                            @if (Auth::user()->role_id > 3)
                                @component('layouts.components.modal',[
                                    'modelName'=>'user',
                                    'action'=>'edit',
                                    'op1'=>'op1',
                                    'op2'=>'user',
                                    'btnSize'=>'small',
                                    'object'=>$user,
                                    'iterator'=>'',
                                    'file'=>true])
                                @endcomponent
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
            <h5 class="mx-4">Activity:</h5>
            <div class="card-body">

                <div class="pagination">
                    {{ $transactions->links("pagination::bootstrap-4") }}
                </div>
                <div class="header row">
                    <div class="col-4 col-sm-4 col-md-3 col-lg-2">Table</div>
                    <div class="col-2 col-sm-2 col-md-3 col-lg-2">Row</div>
                    <div class="col-3 col-sm-3 col-md-3 col-lg-6">Action</div>
                    <div class="col-3 col-sm-3 col-md-3 col-lg-2">Create</div>
                </div>

                <div id="accordion">
                    @foreach ($user->transactions->sortByDesc('id') as $key => $transaction)
                        <div class="card mb-1">
                            <div class="card-header" id="heading{{$key}}">
                                    <div class="h5 my-0 row" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                        <a    class="col-6 col-sm-4 col-md-3 col-lg-2" href="/{{$transaction->table_name}}">{{$transaction->table_name}}</a>
                                        <a    class="col-2 col-sm-2 col-md-3 col-lg-2" href="/{{str_singular($transaction->table_name)}}/show/{{$transaction->row_id}}">{{$transaction->row_id}}</a>
                                        <span class="col-6 col-sm-3 col-md-3 col-lg-6 {{($transaction->action=='destroy') ? 'text-danger':''}}">{{$transaction->action}}</span>
                                        <span class="col-10 col-sm-3 col-md-3 col-lg-2" title="{{$transaction->created_at}}">{{$transaction->created_at->diffForHumans()}}</span>
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
    </div>
@endsection
