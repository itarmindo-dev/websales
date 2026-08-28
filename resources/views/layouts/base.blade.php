<!DOCTYPE html>
<html lang="en" @yield('html-attributes')>

<head>
    @include('layouts.partials.google-tag-manager-head')
    @include('layouts.partials.title-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--===== CSS LINK =======-->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slick-slider/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/slick-slider/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    @vite(['resources/css/app.css'])

    @yield('css')

</head>

<body @yield('body-attributes')>
    @include('layouts.partials.google-tag-manager-body')

    @include('layouts.partials.loader')

    @yield('header')

    @yield('content')

    @yield('scripts')

    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    @vite(['resources/js/app.js', 'resources/js/main.js'])
</body>

</html>
