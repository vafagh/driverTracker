@extends('layouts.app')
@section('content')
    <div class="card">
        @component('driver.header',['driver'=>$driver])
        @endcomponent

        @component('rideable.lines',
            [
                'driver'=>$driver,
                'ongoingRides' => $ongoingRides,
                'date' => $request->input('date'),
                'finishedRides' => $finishedRides,
                'defaultPickups' => $defaultPickups,
                'currentUnassign' => $currentUnassign
            ])
        @endcomponent

        @component('fillup.lines',['driver'=>$driver])
        @endcomponent
{{--
        @component('service.lines',['driver'=>$driver])
        @endcomponent --}}

    </div>

@endsection
