<x-guest-layout>
    <x-auth.card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.notices.forgot-password') }}
        </div>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <x-form method="POST" :action="route('password.email')">
            <!-- Email Address -->
            <x-form.control id="email" :label="__('auth.fields.email')">
                <x-form.input required type="email" :value="old('email')" placeholder="john@example.com" autofocus />
            </x-form.control>

            <x-slot name="buttons">
                <a class="underline text-primary hover:text-emerald-900" href="{{ route('login') }}">
                    {{ __('auth.actions.login') }}
                </a>

                <x-form.button type="submit" variant="primary">{{ __('auth.actions.request') }}</x-form.button>
            </x-slot>
        </x-form>
    </x-auth.card>
</x-guest-layout>
