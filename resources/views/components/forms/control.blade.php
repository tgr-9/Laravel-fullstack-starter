@props([
    'id',
    'label',
    'required' => false,
    'error' => null,
])

<div {{ $attributes->merge(['class' => 'text-gray-700 flex flex-col gap-1']) }}>
    <label :for="$id" class="font-semibold">
        <span>{{ $label }}</span>
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>

    {{ $slot }}
</div>
