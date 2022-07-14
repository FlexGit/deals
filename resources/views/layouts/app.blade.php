<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Сделки') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.autocomplete.min.js') }}" defer></script>
    <script src="{{ asset('js/moment.min.js') }}" defer></script>
    <script src="{{ asset('js/moment-with-locales.min.js') }}" defer></script>
    <script src="{{ asset('js/common.js?v=' . time()) }}" defer></script>
    @if(Route::is('deal-index') || Route::is('deal-edit'))
        <script src="{{ asset('js/deal.js?v=' . time()) }}" defer></script>
    @elseif(Route::is('contractor-index') || Route::is('contractor-edit') || Route::is('passport-edit'))
        <script src="{{ asset('js/contractor.js?v=' . time()) }}" defer></script>
    @elseif(Route::is('coin-index') || Route::is('coin-edit'))
        <script src="{{ asset('js/coin.js?v=' . time()) }}" defer></script>
    @elseif(Route::is('legal-entity-index') || Route::is('legal-entity-edit'))
        <script src="{{ asset('js/legal-entity.js?v=' . time()) }}" defer></script>
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/toastr/toastr.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">--}}
    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/common.css?v=' . time()) }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fa-solid fa-handshake"></i>&nbsp;&nbsp;{{ config('app.name', 'Сделки') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Авторизация') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item pr-5">
                                <a class="nav-link" href="{{ route('deal-index') }}">
                                    <i class="fa-solid fa-handshake"></i>&nbsp;&nbsp;{{ __('Сделки') }}
                                </a>
                            </li>

                            <li class="nav-item dropdown pr-5">
                                <a id="navbarDropdownHelper" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-list"></i>&nbsp;&nbsp;{{ __('Справочники') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownHelper">
                                    <a class="dropdown-item" href="{{ route('contractor-index') }}">
                                        <i class="fa-solid fa-user-tie"></i>&nbsp;&nbsp;{{ __('Контрагенты') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('coin-index') }}">
                                        <i class="fa-solid fa-coins"></i>&nbsp;&nbsp;{{ __('Монеты') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('legal-entity-index') }}">
                                        <i class="fa-regular fa-registered"></i>&nbsp;&nbsp;{{ __('Юридические лица') }}
                                    </a>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-user"></i>&nbsp;&nbsp;{{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;&nbsp;{{ __('Выход') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
