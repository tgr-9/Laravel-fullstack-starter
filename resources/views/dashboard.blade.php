<x-app-layout>
    <x-slot name="header">
        {{ __('dashboard.routes.index') }}
    </x-slot>

    <div class="bg-white overflow-hidden p-6 shadow-sm sm:rounded-lg sm:border border-gray-200">
        <h3 class="">{{ __('dashboard.welcome-notice', ['user' => Auth::user()->name]) }}</h3>
    </div>
</x-app-layout>
