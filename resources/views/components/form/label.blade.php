@props(['for'])

@aware([
    'required' => false,
])

<label {{ $attributes->class(['select-none'])->merge(['for' => $for]) }}>
    {{ $slot }}
    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>
