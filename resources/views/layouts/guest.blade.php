<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.google-tag-manager-head')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Admin - Armindo Perkasa</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @include('layouts.partials.google-tag-manager-body')
        <div class="flex min-h-screen flex-col items-center justify-center bg-green-50 px-4 py-8">
            <div>
                <a href="{{ route('home') }}" aria-label="Kembali ke website Armindo Perkasa">
                    <x-application-logo class="h-14 w-60" />
                </a>
            </div>

            <div class="mt-6 w-full max-w-md overflow-hidden rounded-xl border border-gray-200 bg-white px-6 py-6 shadow-lg sm:px-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
