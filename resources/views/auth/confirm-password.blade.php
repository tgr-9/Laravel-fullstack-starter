<x-guest-layout>
    <x-auth-card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.notices.confirm-password') }}
        </div>

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')">
                <x-forms.input id="password" type="password" name="password" required autocomplete="current-password" />
            </x-forms.control>

            <div class="flex justify-end mt-4">
                <x-forms.button type="submit">{{ __('auth.actions.confirm') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
