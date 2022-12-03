@props(['active'])

@php
$class = [
    'inline-flex items-center font-bold py-2 px-4 border-r-3 leading-5 focus:outline-none transition duration-150 ease-in-out',
    ($active ?? false)
        ? 'border-emerald-600 focus:border-emerald-700'
        : 'border-transparent hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300'
];
@endphp

<a {{ $attributes->class($class) }}>
    {{ $slot }}
</a>
