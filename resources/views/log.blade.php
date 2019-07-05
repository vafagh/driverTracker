@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            {{$appName}}
            v{{$gitRevList}}
        </div>
        <div class="card-body">
            <div class="h3">
                All commits:
            </div>
            <pre>
                {{$gitShortlog}}
            </pre>
            {{-- {{shell_exec("git shortlog")}} --}}
        </div>
    </div>

    <div class="card-footer">The goal of Computer Science is to build something that will last at least until we've finished building it. </div>
@endsection
