<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Profil sales resmi HINO Armindo Perkasa.' }}">
    <title>{{ $title ?? 'Sales HINO Armindo Perkasa' }}</title>
    <link rel="icon" href="{{ asset('img/icon/logohino2.png') }}">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    {{ $slot }}
</body>
</html>
