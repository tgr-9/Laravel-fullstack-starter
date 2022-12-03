@props([
    'id',
    'name' => null,
    'label' => ''
])

@aware([
    // 'id',
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'error' => null,
])

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    <x-form.input id="{{ $id }}" type="checkbox" />
    <x-form.label for="{{ $id }}">{{ $label }}</x-form.label>
</div>
