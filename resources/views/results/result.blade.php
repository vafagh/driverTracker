@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header row m-0 bg-primary text-white">
            <div class="col-10 h3">Results</div>
        </div>
        @if ($invoices->count()+$drivers->count()+$trucks->count()+$locations->count()+$fillups->count()>0)

            @component('results.show',['colection'=>$invoices])
            @endcomponent

            @component('results.show',['colection'=>$drivers])
            @endcomponent

            @component('results.show',['colection'=>$trucks])
            @endcomponent

            @component('results.show',['colection'=>$locations])
            @endcomponent

            @component('results.show',['colection'=>$fillups])
            @endcomponent

        @else
            <div class="card-header">
                No match found!
            </div>
        @endif
        <form method="get" action="/search/">
            <div class="row pb-4 m-auto">

                <div class="form-control border border-white col-12 col-md-7 col-lg-8 text-right">
                    Search by created date
                </div>
                <div class="col-12 col-md-5 col-lg-4 row">
                    <input name="q" class="form-control d-inline w-75" type="date">
                    <button class="form-control btn d-inline w-25" type="submit">Search</button>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
@endsection
