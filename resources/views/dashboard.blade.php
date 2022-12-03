<x-app-layout>
    <x-slot name="header">
        <h2 class="flex-1 font-semibold text-xl text-gray-800 leading-none">
            {{ __('dashboard.routes.index') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden p-6 shadow-sm sm:rounded-lg sm:border border-gray-200">
        <h3 class="">{{ __('dashboard.welcome-notice', ['user' => Auth::user()->name]) }}</h3>
    </div>
</x-app-layout>
