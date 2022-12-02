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
    <x-forms.input id="{{ $id }}" type="checkbox" />
    <x-forms.label for="{{ $id }}">{{ $label }}</x-forms.label>
</div>
