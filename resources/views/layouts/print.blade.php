<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('ПРИЕМО ПЕРЕДАТОЧНЫЙ АКТ КУПЛИ-ПРОДАЖИ МОНЕТ') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/rubles.js') }}"></script>
    <script src="{{ asset('js/print.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">
</head>
<body onload="window.print()">
    <page size="A4">
        @yield('content')
    </page>
</body>
</html>
