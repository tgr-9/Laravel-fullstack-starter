<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </a>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
