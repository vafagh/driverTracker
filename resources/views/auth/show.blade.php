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
                        <div class="col-4 text-right pt-2">@if (Auth::user()->role_id > 3)
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
            <div class="card">
                <div class="card-header row m-0">
                    All Transaction
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="6">
                                    <div class="pagination">
                                        {{ $transactions->links("pagination::bootstrap-4") }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Create</th>
                                <th>Action</th>
                                <th>Table</th>
                                <th>Row</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->transactions->sortByDesc('id') as $key => $transaction)
                                <tr>

                                    <td>
                                        <span title="{{$transaction->created_at}}">{{$transaction->created_at->diffForHumans()}}</span>
                                    </td>

                                    <td>
                                        {{$transaction->action}}
                                    </td>

                                    <td>
                                        {{$transaction->table_name}}
                                    </td>

                                    <td>
                                        {{$transaction->row_id}}
                                    </td>

                                    <td class="fixesWidthFont">
                                        <div class="text-danger">
                                            {{-- <strong>Old: </strong> --}}
                                            {{-- {{$transaction->last_data}} --}}
                                            @component('layouts.row',['data' =>$transaction->last_data])
                                            @endcomponent
                                        </div>
                                        <div class="text-success">
                                            <strong>New: </strong>
                                            {{$transaction->new_data}}
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">
                                    <div class="pagination">
                                        {{ $transactions->links("pagination::bootstrap-4") }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
