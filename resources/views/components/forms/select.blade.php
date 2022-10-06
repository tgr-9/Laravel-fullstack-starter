@php
$class = [
    'rounded shadow border border-gray-300 px-4 py-2 transition ease-in-out duration-150',
    'ring-gray-300 focus:ring focus:ring-gray-200 focus:outline-gray-400',
    'disabled:bg-gray-100 readonly:bg-gray-50'
];
@endphp

<select {!! $attributes->merge(['class' => \implode(' ', $class) ]) !!}>
    {{ $slot }}
</select>
