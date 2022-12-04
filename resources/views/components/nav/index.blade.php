<aside {{ $attributes->class(['h-screen', 'sm:border-r', '<sm:shadow-md']) }}>
    <div class="flex-grow relative">
        <header class="w-full px-4 py-2">
            {{ $header }}
        </header>

        <nav class="flex flex-col gap-1" role="navigation">
            {{ $slot }}
        </nav>
    </div>

    <footer class="w-full flex-grow-0 flex-shrink-0 p-2">
        <x-dropdown placement="top-left">
            <x-slot name="trigger" class="select-none justify-between w-full cursor-pointer">
                <div class="font-medium px-2 text-left">
                    <div class="text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </x-slot>

            <x-dropdown.link x-bind:href="'#'">Account</x-dropdown.link>
            <x-auth.logout :is-dropdown="true" />
        </x-dropdown>
    </footer>
</aside>
