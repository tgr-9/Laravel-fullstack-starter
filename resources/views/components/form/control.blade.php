@props([
    'id',
    'label' => null,
    'hint' => null,
    'required' => false,
    'inline' => false,
])

@php
$class = [
    'gap-1',
    ($inline ? 'inline-flex items-center' : 'flex flex-col')
];
@endphp

<div {{ $attributes->class($class)->merge() }}>
    <x-form.label for="{{ $id }}" class="font-semibold text-md">{{ $label }}</x-form.label>

    {{ $slot }}

    @if($hint)
        <p class="text-gray-500">{{ $hint }}</p>
    @endif

    @error($id)
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
