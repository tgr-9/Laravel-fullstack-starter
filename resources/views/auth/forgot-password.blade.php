<x-guest-layout>
    <x-auth.card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.notices.forgot-password') }}
        </div>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Email Address -->
            <x-forms.control id="email" :label="__('auth.fields.email')">
                <x-forms.input required type="email" :value="old('email')" placeholder="john@example.com" autofocus />
            </x-forms.control>

            <div class="flex items-center justify-between pt-4 border-t-1">
                <a class="underline text-primary hover:text-emerald-900" href="{{ route('login') }}">
                    {{ __('auth.actions.login') }}
                </a>

                <x-forms.button type="submit" variant="primary">{{ __('auth.actions.request') }}</x-forms.button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
