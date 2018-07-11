@extends('layouts.app')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-body">

                <ul class="list-group" id='driverd'>
                    <li class="driver list-group-item py-0 list-group-item-secondary">
                        <div class="row m-0 p-0">
                            <div class='col-4 text-center'>
                                Info
                            </div>
                            <div class="col-4">Created at</div>
                            <div class='col-2'>Miles Driven</div>
                            <div class='col-2'>Total Trip</div>
                        </div>
                    </li>
                    @foreach ($drivers as $driver)
                        @component('layouts.driverslist',['driver'=> $driver])
                            File Missing!
                        @endcomponent
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
