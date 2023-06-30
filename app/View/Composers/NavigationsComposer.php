<?php

namespace App\View\Composers;

use Illuminate\View\View;

class NavigationsComposer
{
    public function compose(View $view)
    {
        $view->with('navigations', [
            'main' => $this->main(),
            'user' => $this->user(),
        ]);
    }

    protected function main()
    {
        return [
            [
                'route' => 'home',
                'label' => __('dashboard.menu'),
                'icon' => 'tabler:dashboard',
            ],
            [
                'route' => 'users.home',
                'label' => __('users.menu'),
                'icon' => 'tabler:users',
            ],
            [
                'type' => 'devider',
            ],
            [
                'route' => null,
                'label' => 'Sample Menu',
                'icon' => 'tabler:box',
                'children' => [
                    [
                        'route' => null,
                        'label' => 'Sample SubMenu 1',
                        'icon' => 'tabler:box',
                    ],
                    [
                        'route' => null,
                        'label' => 'Sample SubMenu 2',
                        'icon' => 'tabler:box',
                    ],
                ],
            ],
        ];
    }

    protected function user()
    {
        return [
            [
                'route' => null,
                'label' => __('account.profile.menu'),
                'icon' => 'tabler:user',
            ],
            [
                'route' => null,
                'label' => __('account.settings.menu'),
                'icon' => 'tabler:settings',
            ],
            [
                'route' => null,
                'label' => __('account.supports.menu'),
                'icon' => 'tabler:help',
            ],
            [
                'type' => 'devider',
            ],
            [
                'route' => 'logout',
                'label' => __('auth.actions.logout'),
                'icon' => 'tabler:logout',
            ],
        ];
    }
}
