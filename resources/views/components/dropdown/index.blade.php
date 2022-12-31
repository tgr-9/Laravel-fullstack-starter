@props([
    'placement' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white'
])

@php
switch ($placement) {
    case 'top':
        $alignmentClasses = 'origin-top-left top-[100%]';
        break;
    case 'bottom':
        $alignmentClasses = 'origin-bottom-left bottom-[100%]';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}
@endphp

<div {{ $attributes->class('relative')->merge() }}
    x-data="{
        open: false,
        placement: @js($placement),
        toggle: (e, placement) => {
            {{-- $refs.menu.style.width = e.currentTarget.parentNode.offsetWidth+'px' --}}
            if (placement.includes('top')) {
                $refs.menu.style.bottom = (innerHeight - e.currentTarget.parentNode.offsetTop)+'px'
            }
            if (placement.includes('bottom')) {
                $refs.menu.style.top = (e.currentTarget.parentNode.offsetTop + 24)+'px'
            }
            if (placement.includes('left')) {
                $refs.menu.style.left = e.currentTarget.parentNode.offsetLeft+'px'
            }
            if (placement.includes('right')) {
                $refs.menu.style.right = (innerWidth - e.currentTarget.parentNode.offsetLeft - e.currentTarget.parentNode.offsetWidth)+'px'
            }
        }
    }"
    @click.outside="open = false"
    @close.stop="open = false">
    <button {{ $trigger->attributes->class(['flex', 'gap-1', 'items-center', 'focus:outline-none', 'focus:text-gray-700']) }}
        @click="toggle($event, placement); open = !open"
        type="button">
        {{ $trigger }}
    </button>

    <template x-teleport="#dropdowns-wrapper">
        <div x-show="open" x-ref="menu"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 w-48 rounded-md shadow-lg {{ $alignmentClasses }}"
            @click="open = false">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">{{ $slot }}</div>
        </div>
    </template>
</div>
