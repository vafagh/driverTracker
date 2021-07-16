@extends('layouts.app')
@section('content')
    <div class="card">
        @component('driver.header',['driver'=>$driver])
        @endcomponent

        @component('rideable.locationAssign',[
                'driver'=>$driver,
                'date' => $request->input('date'),
                'shift' => $request->input('shift'),
                'today' => $today,
                'defaultPickups' => $defaultPickups,
                'unassignLocations' => $unassignLocations,
                'currentUnassign' => $currentUnassign
            ])
        @endcomponent

        @component('rideable.lines',[
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
    <script type="text/javascript">
    function setTextAndCombo(a,b,c,d){
        el1 = document.getElementById(a);
        el1.value=c;
        el2 = document.getElementById(b);
        el2.value=d;
console.log(el2,el2.value);
    }
    </script>

@endsection
