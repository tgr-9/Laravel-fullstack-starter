@props([
    'id',
    'name' => null,
    'value' => null,
    'checked' => false
])

@aware([
    'disabled' => false,
])

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <x-form.input id="{{ $id }}" type="checkbox" :checked="$checked" :disabled="$disabled" :value="$value" />
    <x-form.label for="{{ $id }}">{{ $slot }}</x-form.label>
</div>
