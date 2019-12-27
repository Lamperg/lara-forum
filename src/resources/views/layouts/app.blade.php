<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Javascript App Configuration -->
    @include('layouts._jsConfigs')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        body {
            padding-bottom: 100px;
        }

        .level {
            display: flex;
            align-items: center;
        }

        .flex {
            flex: 1;
        }

        .ais-Highlight-highlighted {
            background: yellow;
        }

        .ais-RefinementList-list {
            margin-bottom: 0;
        }

        [v-cloak] {
            display: none;
        }
    </style>

    @yield('head')
</head>
<body>
<div id="app">
    @include('layouts._nav')

    <main class="py-4">
        @yield('content')
    </main>

    <flash-message message="{{ session('flash') }}"></flash-message>
</div>
</body>
</html>
