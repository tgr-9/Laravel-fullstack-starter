<x-guest-layout>
    <x-auth.card>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.notices.verify-email') }}
        </div>

        <x-auth.session-status class="mb-4" :status="session('status')" />

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <x-forms.button type="submit" variant="primary">{{ __('auth.actions.resend') }}</x-forms.button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-forms.button type="submit">{{ __('auth.actions.logout') }}</x-forms.button>
            </form>
        </div>
    </x-auth.card>
</x-guest-layout>
