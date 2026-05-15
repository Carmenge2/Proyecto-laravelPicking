<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Picking') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-orange-50">
            <div class="mb-4">
                <a href="/">
                    <img class="mx-auto h-16 w-auto" src="{{ asset('logo_picking.png') }}" alt="Picking">
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-6 bg-white shadow-sm rounded-2xl border border-orange-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
