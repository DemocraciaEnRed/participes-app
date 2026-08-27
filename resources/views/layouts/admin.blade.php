<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ENABLE THIS TAG IF YOU DONT WANT ROBOTS TO INDEX YOUR WEB --}}
    <meta name="robots" content="noindex">
    <link rel="icon" type="image/png" sizes="250x250" href="{{asset(app_setting('app_favicon','/favicon.png'))}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('metatags')
        @yield('metatags')
    @else
        @include('partials.metatags')
    @endif

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" />
    @yield('stylesheets')

    <!-- Scripts -->
    @yield('headscripts')
    @vite(['resources/js/admin-app.js'])
    @if (app_setting('app_google_analytics_4_id'))
       @include('layouts.googleAnalytics')
    @endif
</head>

<body>
    <div id="app">
        @include('layouts.navbar')
        @include('partials.flashMessage')
        @include('layouts.header')
        @yield('content')
    </div>
    @include('layouts.footer')
    <script type="text/javascript">
        window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
    </script>
</body>

</html>
