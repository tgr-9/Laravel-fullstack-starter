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
                        <th class="w-4 text-left">User</th>
                        <th class="w-3 text-left">Email</th>
                        <th class="w-1/8 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <template x-if="busy">
                        <tr class="no-content">
                            <td colspan="3" class="text-center">Loading</td>
                        </tr>
                    </template>
                    <template x-for="user in users.data">
                        <tr :key="user.id">
                            <td x-text="user.name"></td>
                            <td x-text="user.email"></td>
                            <td class="text-center">
                                action
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </x-card>
</x-app-layout>
