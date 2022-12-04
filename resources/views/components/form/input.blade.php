@props([
    'type',
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

    case 'checkbox':
    case 'radio':
        array_push($class, 'checked:bg-primary text-primary');
        break;

    default:
        break;
};
@endphp

<input @disabled($disabled)
    {{ $required ? 'required aria-required' : '' }}
    {{ $readonly ? 'readonly aria-readonly' : '' }}
    {!! $attributes->class($class)->merge(['type' => $type, 'id' => $id, 'name' => $name]) !!}
/>
