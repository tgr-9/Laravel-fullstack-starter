<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Name -->
            <x-forms.control id="name" :label="__('Name')" required>
                <x-forms.input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
            </x-forms.control>

            <!-- Email Address -->
            <x-forms.control id="email" :label="__('Email')" required>
                <x-forms.input id="email" type="email" name="email" :value="old('email')" required placeholder="john@example.com" />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('Password')" required>
                <x-forms.input id="password" type="password" name="password" required autocomplete="new-password" />
            </x-forms.control>

            <!-- Confirm Password -->
            <x-forms.control id="password_confirmation" :label="__('Confirm Password')" required>
                <x-forms.input id="password_confirmation" type="password" name="password_confirmation" required />
            </x-forms.control>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-emerald-800 hover:text-emerald-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-forms.button type="submit" variant="primary" class="ml-3">{{ __('Register') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
