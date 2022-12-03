@props(['value' => null])

<label {!! $attributes->merge(['class' => 'text-gray-700 select-none']) !!}>
    {{ $value ?? $slot }}
</label>
