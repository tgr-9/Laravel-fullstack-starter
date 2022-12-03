<x-guest-layout>
    <x-auth.card>
        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Employee ID -->
            <x-forms.control id="username" :label="__('auth.fields.username')">
                <x-forms.input required type="text" :value="old('username')" placeholder="John Doe" autofocus />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')">
                <x-forms.input required type="password" autocomplete="current-password" />
            </x-forms.control>

            <!-- Remember Me -->
            <x-forms.checkbox id="remember" :label="__('auth.fields.remember')" />

            <div class="flex items-center justify-between pt-4 border-t-1">
                @if (Route::has('password.request'))
                    <a class="underline text-primary hover:text-emerald-900" href="{{ route('password.request') }}">
                        {{ __('auth.actions.forgot') }}
                    </a>
                @endif

                <x-forms.button type="submit" variant="primary">{{ __('auth.actions.login') }}</x-forms.button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
