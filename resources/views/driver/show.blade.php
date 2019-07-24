@extends('layouts.app')
@section('content')
    <div class="card">
        @component('driver.header',['driver'=>$driver])
        @endcomponent

        @component('rideable.locationAssign',
            [
                'driver'=>$driver,
                'date' => $request->input('date'),
                'today' => $today,
                'defaultPickups' => $defaultPickups,
                'unassignLocations' => $unassignLocations,
                'currentUnassign' => $currentUnassign
            ])
        @endcomponent

        @component('rideable.lines',
            [
                'driver'=>$driver,
                'ongoingRides' => $ongoingRides,
                'finishedRides' => $finishedRides,
            ])
        @endcomponent

        @component('fillup.lines',['driver'=>$driver])
        @endcomponent
{{--
        @component('service.lines',['driver'=>$driver])
        @endcomponent --}}

    </div>

@endsection
