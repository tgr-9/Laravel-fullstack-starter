@props([
    'name' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

@aware([
    'id',
    'required' => false,
    'error' => null,
])

@php
$class = [
    'shadow border-gray-300 transition ease-in-out duration-150 disabled:bg-gray-100 readonly:bg-gray-50',
    'focus:ring-primary focus:outline-none focus:border-primary focus-visible:ring-primary focus:ring-opacity-20',
];

$name = $name ?? $id;
@endphp

<select @disabled($disabled)
    {{ $required ? 'required aria-required' : '' }}
    {{ $readonly ? 'readonly aria-readonly' : '' }}
    {!! $attributes->class($class)->merge(['id' => $id, 'name' => $name ]) !!}>
    {{ $slot }}
</select>
