<x-app-layout>
    <x-slot name="header">
        {{ __('users.routes.index') }}
    </x-slot>

    <x-card>
        <div x-data="{ users: {}, busy: true, route: @js(route('users.index')) }"
            x-init="$nextTick(async () => {
                const { data: body } = await axios.get(route)
                users = body
                busy = users.data.length === 0
            })">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-4 text-left">{{ __('users.table.name') }}</th>
                        <th class="w-3 text-left">{{ __('users.table.email') }}</th>
                        <th class="w-1/8 text-center">{{ __('actions.tables.column') }}</th>
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
                                <a :href="route.concat('/', user.id)" x-text="user.name"></a>
                            </td>
                            <td>
                                <a :href="'mailto:'.concat(user.email)" target="__blank" x-text="user.email"></a>
                            </td>
                            <td class="text-center">
                                {{ __('actions.tables.column') }}
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </x-card>
</x-app-layout>
