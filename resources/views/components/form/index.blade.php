@props([
    'action',
    'method'
])

@php
$override = false;
if (! in_array(strtolower($method), ['get', 'post'])) {
    $override = $method;
    $method = 'POST';
}
@endphp

<x-form.validation-errors class="mb-4" :errors="$errors" />

<form class="flex flex-col gap-4" {{ $attributes->merge(['method' => $method, 'action' => $action, 'x-data' => '{}']) }}>
    @csrf
    @if($override)
    @method($override)
    @endif

    {{ $slot }}

    <footer {{ $buttons->attributes->class(['flex', 'items-center', 'justify-between', 'pt-4', 'border-t-1']) }}>
        {{ $buttons }}
    </footer>
</form>
