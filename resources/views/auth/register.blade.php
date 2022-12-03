<x-guest-layout>
    <x-auth.card>
        <x-form method="POST" :action="route('register')">
            <!-- Name -->
            <x-form.control id="username" :label="__('auth.fields.username')">
                <x-form.input required type="text" :value="old('username')" placeholder="John Doe" autofocus />
            </x-form.control>

            <!-- Email Address -->
            <x-form.control id="email" :label="__('auth.fields.email')">
                <x-form.input required type="email" :value="old('email')" placeholder="john@example.com" />
            </x-form.control>

            <!-- Password -->
            <x-form.control id="password" :label="__('auth.fields.password')">
                <x-form.input required type="password" autocomplete="new-password" />
            </x-form.control>

            <!-- Confirm Password -->
            <x-form.control id="password_confirmation" :label="__('auth.fields.confirm_password')">
                <x-form.input required type="password" />
            </x-form.control>

            <x-slot name="buttons">
                <a class="underline text-primary hover:text-emerald-900" href="{{ route('login') }}">
                    {{ __('auth.actions.registered') }}
                </a>

                <x-form.button type="submit" variant="primary">{{ __('auth.actions.register') }}</x-form.button>
            </x-slot>
        </x-form>
    </x-auth.card>
</x-guest-layout>
