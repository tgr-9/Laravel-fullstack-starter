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
        <div id="app" class="min-h-screen overflow-hidden bg-gray-50 relative flex text-gray-700" x-data="{ sidebar: false }">
            <x-nav class="bg-white flex flex-col w-60" x-bind:class="[sidebar ? '<sm:absolute' : '<sm:hidden sm:relative']">
                <x-slot name="header">
                    <a href="{{ route('home') }}">
                        <x-application-logo width="180" class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </x-slot>

                @foreach ($menuItems as $menu)
                    <x-nav.link :href="route($menu['route'])" :active="request()->routeIs(...$menu['children'])">{{ $menu['label'] }}</x-nav.link>
                @endforeach
            </x-nav>

            <!-- Page Content -->
            <main class="w-screen">
                <!-- Page Heading -->
                <header class="bg-white w-full shadow">
                    <div class="flex items-center container-fluid gap-2 py-4 px-4 sm:px-6">
                        <a href="{{ route('home') }}" class="rounded-md overflow-hidden sm:hidden">
                            <x-application-logo square initial width="40" class="block h-10 w-auto fill-current text-gray-600" />
                        </a>

                        <h2 class="flex-1 font-semibold text-xl leading-9">
                            {{ $header }}
                        </h2>

                        <button @click="sidebar = ! sidebar" class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </header>

                <div class="py-12 container mx-auto sm:px-6">
                    {{ $slot }}
                </div>
            </main>

            <div id="dropdowns-wrapper"></div>
        </div>
    </body>
</html>
