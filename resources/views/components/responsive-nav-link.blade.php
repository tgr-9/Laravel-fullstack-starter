@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block pl-3 pr-4 py-2 border-l-4 border-emerald-600 text-base font-medium text-emerald-700 bg-emerald-50 focus:outline-none focus:text-emerald-800 focus:bg-emerald-100 focus:border-emerald-700 transition duration-150 ease-in-out'
    : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
