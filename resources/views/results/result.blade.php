@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-white">
            <div class="col-10 h3">Results</div>
        </div>
        @if ($invoices->count()+$drivers->count()+$trucks->count()+$locations->count()+$fillups->count()>0)

            @component('results.show',['colection'=>$invoices])@endcomponent

            @component('results.show',['colection'=>$drivers])@endcomponent

            @component('results.show',['colection'=>$trucks])@endcomponent

            @component('results.show',['colection'=>$locations])@endcomponent

            @component('results.show',['colection'=>$fillups])@endcomponent

        @else
            <div class="card-header">
                No match found!
            </div>
        @endif

    </div>
@endsection
