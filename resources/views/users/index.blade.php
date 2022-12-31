<x-app-layout>
    <x-slot name="header">
        {{ __('users.routes.index') }}
    </x-slot>

    <x-card>
        <div x-data="{
                users: {},
                busy: true,
                route: @js(route('users.index')),
                web: @js(route('users.home'))
            }"
            x-init="$nextTick(async () => {
                const { data: body } = await axios.get(route)
                users = body
                busy = users.data.length === 0
            })">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-4/8 text-left">{{ __('users.table.name') }}</th>
                        <th class="w-3/8 text-left">{{ __('users.table.email') }}</th>
                        <th class="action">{{ __('actions.tables.column') }}</th>
                    </tr>
                </thead>

                <tbody>
                    <template x-if="busy">
                        <tr class="no-content">
                            <td colspan="3" class="text-center">{{ __('actions.no-content') }}</td>
                        </tr>
                    </template>
                    <template x-for="user in users.data">
                        <tr :key="user.id">
                            <td>
                                <a :href="web.concat('/', user.id)" x-text="user.name"></a>
                            </td>
                            <td>
                                <a :href="'mailto:'.concat(user.email)" target="__blank" x-text="user.email"></a>
                            </td>
                            <td class="action">
                                <x-dropdown class="text-left" placement="bottom-right">
                                    <x-slot name="trigger" class="m-auto select-none justify-between cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                        </svg>
                                    </x-slot>

                                    <x-dropdown.link x-bind:href="web.concat('/', user.id)">Detail</x-dropdown.link>
                                </x-dropdown>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </x-card>
</x-app-layout>
