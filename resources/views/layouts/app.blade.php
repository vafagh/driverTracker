<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('metas')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?082818130623" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
    //Static google map hover load
    function loadStatImg(src,imageTarget){
        var list = document.getElementsByClassName(imageTarget);
        for(var i=0;i<list.length;i++){
            list[i].src=src;
        }
    }
    </script>

    <!-- head yield  -->
    @yield('head')

</head>
<body onload="initialize()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Tracker') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @else
                        <ul class="navbar-nav mr-auto">
                            @component('layouts.navs.accordion') @endcomponent
                        </ul>
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <form method="get" action="/search/">
                                    <div class="d-block p-2">
                                        <input name="q" class="form-control d-inline-block" type="text" placeholder="Search...">
                                        {{-- <button class="form-control btn d-inline w-25 mb-1" type="submit">Search</button> --}}
                                    </div>
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="fluid-container row mx-auto p-0">
            <div class="main col-lg-12 col-xl-12 mt-1">

                @if (session('info'))<div class="alert alert-info mt-3 mx-auto">{{ session('info') }}</div>@endif
        		@if (session('error'))<div class="alert alert-danger mt-3 mx-auto">{{ session('error') }}</div>@endif
        		@if (session('warning'))<div class="alert alert-warning mt-3 mx-auto">{{ session('warning') }}</div>@endif
        		@if (session('success'))<div class="alert alert-success mt-3 mx-auto">{{ session('success') }}</div>@endif
        		@if (session('status'))<div class="alert alert-info mt-3 mx-auto">{{ session('status') }}</div>@endif

        		@yield('content')

            </div>
            <div class="side col-lg-12  col-xl-2 sticky-top pt-4 mt-3 p-0">
                @include('layouts.side')
            </div>
        </div>
    </div>
    @if (Auth::check())
        @if ($unasignedRideable->count()>0 && Auth::user()->role_id == 3)
            <audio autoplay src="/snd/BoxingBell.mp3">Your browser does not support the <code>audio</code> element.</audio>
        @endif
    @endif

    @yield('footer-scripts')
</body>
</html>
