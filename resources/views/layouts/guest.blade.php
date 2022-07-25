<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-1KQP24LR0L"></script>

        <!-- Scripts -->
        @vite('resources/client/app.ts')
    </head>

    <body class="font-sans antialiased">
        <div class="text-gray-900">
            {{ $slot }}
        </div>
    </body>
</html>
