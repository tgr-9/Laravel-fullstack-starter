<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Password -->
            <x-forms.control id="password" :label="__('Password')">
                <x-forms.input id="password" type="password" name="password" required autocomplete="current-password" />
            </x-forms.control>

            <div class="flex justify-end mt-4">
                <x-forms.button type="submit">{{ __('Confirm') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
