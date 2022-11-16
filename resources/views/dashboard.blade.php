<x-app-layout>
    <x-slot name="header">
        <h2 class="flex-1 font-semibold text-xl text-gray-800 leading-9">
            {{ __('dashboard.routes.index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __('dashboard.welcome-notice', ['user' => Auth::user()->name]) }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
