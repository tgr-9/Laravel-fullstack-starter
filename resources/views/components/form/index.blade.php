@props([
    'action',
    'method'
])

<x-form.validation-errors class="mb-4" :errors="$errors" />

<form method="{{ $method }}" action="{{ $action }}" class="flex flex-col gap-4">
    @csrf

    {{ $slot }}

    <footer {{ $buttons->attributes->class(['flex', 'items-center', 'justify-between', 'pt-4', 'border-t-1']) }}>
        {{ $buttons }}
    </footer>
</form>
