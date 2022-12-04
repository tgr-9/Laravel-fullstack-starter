@props([
    'type' => 'button',
    'href' => null,
    'variant' => null,
    'size' => null,
])

@php
$class = [
    'inline-flex items-center font-semibold transition ease-in-out duration-150 border border-transparent',
    'rounded hover:shadow focus:ring-opacity-40 focus:outline-opacity-60 disabled:opacity-25 select-none'
];

switch ($size) {
    case 'lg':
        array_push($class, 'px-6 py-2 text-lg');
        break;

    case 'sm':
        array_push($class, 'px-3 py-1 text-sm');
        break;

    default:
        array_push($class, 'px-4 py-2');
        break;
}

switch($variant) {
    case 'primary':
        array_push(
            $class,
            'text-white bg-emerald-700 hover:bg-emerald-600 focus:bg-emerald-600 active:bg-emerald-800',
            'focus:outline-emerald-500 hover:border-emerald-700 focus:border-emerald-700 focus:border-emerald-900'
        );
        break;

    case 'secondary':
        array_push(
            $class,
            'text-gray-700 bg-light-700 hover:bg-light-600 focus:bg-light-600 active:bg-light-800',
            'focus:outline-light-800 hover:border-light-800 focus:border-light-800 focus:border-light-900'
        );
        break;

    default:
        array_push(
            $class,
            'text-white bg-gray-700 hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-800',
            'focus:outline-gray-500 hover:border-gray-700 focus:border-gray-700 focus:border-gray-900'
        );
        break;
};
@endphp

@if(! is_null($href))
<a {{ $attributes->class($class)->merge(['href' => $href]) }}>{{ $slot }}</a>
@else
<button {!! $attributes->class($class)->merge(['type' => $type]) !!}>{{ $slot }}</button>
@endif
