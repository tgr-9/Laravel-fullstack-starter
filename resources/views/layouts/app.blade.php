<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

        <!-- Scripts -->
        @vite(['resources/client/app.ts', 'resources/client/app.css'])
    </head>

    <body class="font-sans antialiased">
        <div id="app" class="min-h-screen bg-gray-50 relative text-gray-700">
            <!-- Page Heading -->
            <header class="bg-white w-full shadow">
                <nav class="relative border-b border-gray-100">
                    @include('layouts.navigation')
                </nav>

                <div class="flex items-center container-fluid py-4 px-4 sm:px-6">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-12 container mx-auto sm:px-6">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
