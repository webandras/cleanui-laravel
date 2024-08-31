<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="data"
    :class="{'dark': darkMode }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.2/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.11.2/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager-overwrite.css') }}">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ url('safari-pinned-tab.svg') }}" color="#0d6efd">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    @stack('head-extra')
    @yield('head')
</head>
<body @scroll="setScrollToTop()">

<section class="admin wrapper">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>

<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

</body>
</html>



