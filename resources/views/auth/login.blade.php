<x-guest-layout>
    <x-auth.card>
        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <x-form method="POST" :action="route('login')">
            <!-- Employee ID -->
            <x-form.control id="username" :label="__('auth.fields.username')">
                <x-form.input required type="text" :value="old('username')" placeholder="John Doe" autofocus />
            </x-form.control>

            <!-- Password -->
            <x-form.control id="password" :label="__('auth.fields.password')">
                <x-form.input required type="password" autocomplete="current-password" />
            </x-form.control>

            <!-- Remember Me -->
            <x-form.checkbox id="remember" value="1">{{ __('auth.fields.remember') }}</x-form.checkbox>

            <x-slot name="buttons">
                @if (Route::has('password.request'))
                    <a class="underline text-primary hover:text-emerald-900" href="{{ route('password.request') }}">
                        {{ __('auth.actions.forgot') }}
                    </a>
                @endif

                <x-form.button type="submit" variant="primary">{{ __('auth.actions.login') }}</x-form.button>
            </x-slot>
        </x-form>
    </x-auth.card>
</x-guest-layout>
