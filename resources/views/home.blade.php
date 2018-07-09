@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul class="deliveries list-group">
                            <li class="list-group-item disabled">Active Deliveries</li>
                            @foreach ($Rideables as $Rideable)
                                <li class="delivery list-group-item">
                                    <span>{{$Rideable->id}}</span>
                                    <span>{{$Rideable->invoice_number}}</span>
                                    <span>{{$Rideable->status}}</span>
                                    <span>{{$Rideable->typr}}</span>
                                    <span>{{$Rideable->description}}</span>
                                    <span>{{$Rideable->created_at}}</span>
                                    <table class="table table-hover">
                                        {{-- <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Driver</th>
                                                <th scope="col">Truck</th>
                                            </tr>
                                        </thead> --}}
                                        <tbody>
                                    {{-- @foreach ($Rideable->rides as $ride)
                                                <tr>
                                                    <th>{{ $ride->id}}</th>
                                                    <td>{{ $ride->driver_id}}</td>
                                                    <td>1{{ $ride->truck->label}}1</td>
                                                </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                            </li>
                        @endforeach

                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
