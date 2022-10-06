<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Name -->
            <x-forms.control id="username" :label="__('auth.fields.username')" required>
                <x-forms.input id="username" type="text" name="username" :value="old('username')" required autofocus placeholder="John Doe" />
            </x-forms.control>

            <!-- Email Address -->
            <x-forms.control id="email" :label="__('auth.fields.email')" required>
                <x-forms.input id="email" type="email" name="email" :value="old('email')" required placeholder="john@example.com" />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')" required>
                <x-forms.input id="password" type="password" name="password" required autocomplete="new-password" />
            </x-forms.control>

            <!-- Confirm Password -->
            <x-forms.control id="password_confirmation" :label="__('auth.fields.confirm_password')" required>
                <x-forms.input id="password_confirmation" type="password" name="password_confirmation" required />
            </x-forms.control>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-emerald-800 hover:text-emerald-900" href="{{ route('login') }}">
                    {{ __('auth.actions.registered') }}
                </a>

                <x-forms.button type="submit" variant="primary" class="ml-3">{{ __('auth.actions.register') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
