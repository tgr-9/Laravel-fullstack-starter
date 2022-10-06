<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-40 h-auto fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Employee ID -->
            <x-forms.control id="employee_id" :label="__('Employee ID')">
                <x-forms.input id="employee_id" type="text" name="employee_id" :value="old('employee_id')" required autofocus />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('Password')">
                <x-forms.input id="password" type="password" name="password" required autocomplete="current-password" />
            </x-forms.control>

            <!-- Remember Me -->
            <div>
                <label for="remember_me" class="inline-flex items-center">
                    <x-forms.input id="remember_me" type="checkbox" name="remember" />
                    <span class="ml-2 text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-emerald-800 hover:text-emerald-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-forms.button type="submit" variant="primary" class="ml-3">{{ __('Log in') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
