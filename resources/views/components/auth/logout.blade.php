@props([
    'is-dropdown' => true
])

@php
    $componentName = $isDropdown ? 'dropdown.link' : 'responsive-nav-link'
@endphp

<form method="POST" action="{{ route('logout') }}">
    @csrf

    <x-dynamic-component :component="$componentName" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
        {{ __('auth.actions.logout') }}
    </x-dynamic-component>
</form>
