<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <x-forms.control id="email" :label="__('auth.fields.email')">
                <x-forms.input required type="email" :value="old('email', $request->email)" placeholder="john@example.com" />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')">
                <x-forms.input required type="password" autocomplete="new-password" />
            </x-forms.control>

            <!-- Confirm Password -->
            <x-forms.control id="password_confirmation" :label="__('auth.fields.confirm_password')">
                <x-forms.input required type="password" />
            </x-forms.control>

            <div class="flex items-center justify-end pt-4 border-t-1">
                <x-forms.button type="submit">{{ __('auth.actions.reset') }}</x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
