<x-guest-layout>
    <x-auth.card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.notices.confirm-password') }}
        </div>

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')">
                <x-forms.input required type="password" autocomplete="current-password" />
            </x-forms.control>

            <div class="flex items-center justify-end pt-4 border-t-1">
                <x-forms.button type="submit" variant="primary">{{ __('auth.actions.confirm') }}</x-forms.button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
