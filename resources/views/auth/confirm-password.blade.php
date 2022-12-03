<x-guest-layout>
    <x-auth.card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.notices.confirm-password') }}
        </div>

        <x-form method="POST" :action="route('password.confirm')">
            <!-- Password -->
            <x-form.control id="password" :label="__('auth.fields.password')">
                <x-form.input required type="password" autocomplete="current-password" />
            </x-form.control>

            <x-slot name="buttons">
                <x-form.button type="submit" variant="primary">{{ __('auth.actions.confirm') }}</x-form.button>
            </x-slot>
        </x-form>
    </x-auth.card>
</x-guest-layout>
