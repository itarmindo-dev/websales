<!DOCTYPE html>
<html lang="id">
<head>
    @include('layouts.partials.google-tag-manager-head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Profil sales resmi HINO Armindo Perkasa.' }}">
    <title>{{ $title ?? 'Sales HINO Armindo Perkasa' }}</title>
    <link rel="icon" href="{{ asset('img/icon/logohino2.png') }}">
    @vite(['resources/css/app.css', 'resources/css/sales-landing.css'])
</head>
<body class="bg-white font-sans text-gray-900 antialiased">
    @include('layouts.partials.google-tag-manager-body')
    {{ $slot }}
</body>
</html>
