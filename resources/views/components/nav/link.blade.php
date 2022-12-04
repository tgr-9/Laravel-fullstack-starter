@props(['active'])

@php
$class = [
    'inline-flex text-gray-600 text-sm leading-7 items-center font-bold py-2 px-4 border-r-3 leading-5 focus:outline-none transition duration-150 ease-in-out',
    ($active ?? false)
        ? 'text-primary bg-emerald-50 border-emerald-600 focus:border-emerald-700'
        : 'border-transparent hover:bg-gray-100 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300'
];
@endphp

<a {{ $attributes->class($class) }}>
    {{ $slot }}
</a>
