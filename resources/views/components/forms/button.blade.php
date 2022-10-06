@props([
    'type' => 'button',
    'variant' => 'default',
])

@php
$class = [
    'inline-flex items-center px-4 py-2 font-semibold',
    'transition ease-in-out duration-150',
    'rounded hover:shadow focus:ring disabled:opacity-25'
];

switch($variant) {
    case 'primary':
        array_push(
            $class,
            'text-white bg-emerald-800 outline-emerald-500',
            'hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:border-emerald-900'
        );
        break;

    case 'secondary':
        array_push($class, 'text-white bg-light-800 hover:bg-light-700 active:bg-light-900 focus:border-light-900');
        break;

    case 'default':
    default:
        array_push($class, 'text-white bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900');
        break;
};
@endphp

<button {{ $attributes->merge([ 'type' => $type, 'class' => \implode(' ', $class) ]) }}>
    {{ $slot }}
</button>
