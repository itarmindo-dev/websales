<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.google-tag-manager-head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="PT Armindo Perkasa, dealer resmi HINO untuk kebutuhan armada bisnis Anda.">
    <title>@yield('title', 'Armindo Perkasa - Dealer Resmi HINO')</title>
    <link rel="icon" href="{{ asset('img/icon/logohino2.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @vite(['resources/css/app.css', 'resources/css/marketing.css', 'resources/js/app.js'])
</head>
<body class="marketing-body">
    @include('layouts.partials.google-tag-manager-body')
    @yield('content')
</body>
</html>
