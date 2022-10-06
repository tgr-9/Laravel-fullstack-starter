@props([
    'type',
    'disabled' => false,
    'readonly' => false,
    'errored' => false,
])

@php
$class = [
    'shadow border border-gray-300 transition ease-in-out duration-150',
    'ring-gray-300 focus:ring focus:ring-gray-200 focus:outline-gray-400',
    'disabled:bg-gray-100 readonly:bg-gray-50'
];

if ($type !== 'radio') {
    array_push($class, 'rounded');
}

switch($type) {
    case 'file':
        array_push($class, 'p-[0.3rem]');
        break;

    case 'color':
        array_push($class, 'px-[2px]');
        break;

    case 'text':
    case 'email':
    case 'url':
    case 'password':
    case 'number':
    case 'date':
    case 'datetime-local':
    case 'month':
    case 'search':
    case 'tel':
    case 'time':
    case 'week':
        array_push($class, 'px-4 py-2');
        break;

    default:
        break;
};
@endphp

<input
    {{ $disabled ? 'disabled aria-disabled' : '' }}
    {{ $readonly ? 'readonly aria-readonly' : '' }}
    {!! $attributes->merge(['class' => \implode(' ', $class), 'type' => $type]) !!}
/>
