@props([
    'id',
    'label' => null,
    'hint' => null,
    'required' => false,
    'inline' => false,
    'error' => null,
])

@php
$class = [
    'text-gray-700 gap-1',
    ($inline ? 'inline-flex items-center' : 'flex flex-col')
];
@endphp

<div {{ $attributes->merge(['class' => implode(' ', $class)]) }}>
    <x-form.label for="{{ $id }}" class="font-semibold text-md">
        <span>{{ $label }}</span>
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </x-form.label>

    {{ $slot }}

    @if($hint)
    <p class="text-gray-500">{{ $hint }}</p>
    @endif

    @error($id)
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
