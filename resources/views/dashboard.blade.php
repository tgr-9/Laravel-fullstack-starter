<x-app-layout>
    <x-slot name="header">
        {{ __('dashboard.routes.index') }}
    </x-slot>

    <x-card class="p-6">
        <h3 class="">{{ __('dashboard.welcome-notice', ['user' => Auth::user()->name]) }}</h3>
    </x-card>
</x-app-layout>
