<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/svg+xml" href="{{ asset('/assets/favicon.svg') }}">
        <link rel="apple-touch-icon" href="{{ asset('/assets/icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('/build/manifest.webmanifest') }}" />

        <script>
            window.__navigations = @json($navigations);
            window.__translations = @json($translations);
        </script>

        <!-- Scripts -->
        @vite('resources/client/app.ts')

        @inertiaHead
    </head>

    <body class="font-sans antialiased min-h-screen w-full">
        @inertia

        <div id="outer-app"></div>
    </body>
</html>
