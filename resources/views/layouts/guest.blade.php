<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>

    <body class="font-sans antialiased">
        <div class="text-gray-900">
            {{ $slot }}
        </div>

        <!-- Scripts -->
        @push('scripts')
            <script src="{{ asset(mix('/js/manifest.js')) }}"></script>
            <script src="{{ asset(mix('/js/vendor.js')) }}"></script>
            <script src="{{ asset(mix('/js/app.js')) }}"></script>
        @endpush

        @stack('scripts')
    </body>
</html>
