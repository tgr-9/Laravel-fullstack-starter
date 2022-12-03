<x-guest-layout>
    <x-auth.card>
        <x-form method="POST" :action="route('password.update')">
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <x-form.control id="email" :label="__('auth.fields.email')">
                <x-form.input required type="email" :value="old('email', $request->email)" placeholder="john@example.com" />
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
                <x-form.button type="submit" variant="primary">{{ __('auth.actions.reset') }}</x-form.button>
            </x-slot>
        </x-form>
    </x-auth.card>
</x-guest-layout>
