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
                <x-forms.input id="email" type="email" name="email" :value="old('email', $request->email)" required />
            </x-forms.control>

            <!-- Password -->
            <x-forms.control id="password" :label="__('auth.fields.password')">
                <x-forms.input id="password" type="password" name="password" required autocomplete="new-password" />
            </x-forms.control>

            <!-- Confirm Password -->
            <x-forms.control id="password_confirmation" :label="__('auth.fields.confirm_password')">
                <x-forms.input id="password_confirmation" type="password" name="password_confirmation" required />
            </x-forms.control>

            <div class="flex items-center justify-end mt-4">
                <x-forms.button type=submit>
                    {{ __('auth.actions.reset') }}
                </x-forms.button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
