<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Employee ID -->
            <x-forms.control id="username" :label="__('auth.fields.username')">
                <x-forms.input id="username" type="text" name="username" :value="old('username')" required autofocus placeholder="John Doe" />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')">
                <x-forms.input id="password" type="password" name="password" required autocomplete="current-password" />
            </x-forms.control>

            <!-- Remember Me -->
            <div>
                <label for="remember" class="inline-flex items-center">
                    <x-forms.input id="remember" type="checkbox" name="remember" />
                    <span class="ml-2 text-gray-600">{{ __('auth.fields.remember') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-emerald-800 hover:text-emerald-900" href="{{ route('password.request') }}">
                        {{ __('auth.actions.forgot') }}
                    </a>
                @endif

                <x-forms.button type="submit" variant="primary" class="ml-3">{{ __('auth.actions.login') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
