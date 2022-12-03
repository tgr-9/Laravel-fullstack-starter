<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/client/app.ts', 'resources/client/app.css'])
    </head>

    <body class="font-sans antialiased auth-bg" style="background-image: url('{{ asset('/app-bg.jpeg') }}');">
        <div class="text-gray-700">
            {{ $slot }}
        </div>
    </body>
</html>
