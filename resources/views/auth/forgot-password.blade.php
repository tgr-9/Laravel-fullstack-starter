<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Email Address -->
            <x-forms.control id="email" :label="__('Email')">
                <x-forms.input id="email" type="email" name="email" :value="old('email')" required autofocus />
            </x-forms.control>

            <div class="flex items-center justify-end mt-4">
                <x-forms.button type="submit" variant="primary">{{ __('Email Password Reset Link') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
