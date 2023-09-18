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
                'type' => 'divider',
            ],
            [
                'route' => 'parent.home',
                'label' => 'Sample Menu',
                'icon' => 'tabler:box',
                'children' => [
                    [
                        'route' => 'parent.child-1.home',
                        'label' => 'Sample SubMenu 1',
                        'icon' => 'tabler:box',
                    ],
                    [
                        'route' => 'parent.child-2.home',
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
                'route' => 'account.home',
                'label' => __('account.profile.menu'),
                'icon' => 'tabler:user',
            ],
            [
                'route' => 'account.settings',
                'label' => __('account.settings.menu'),
                'icon' => 'tabler:settings',
            ],
            [
                'route' => 'supports.home',
                'label' => __('account.supports.menu'),
                'icon' => 'tabler:help',
            ],
            [
                'type' => 'divider',
            ],
            [
                'route' => 'logout',
                'label' => __('auth.actions.logout'),
                'icon' => 'tabler:logout',
            ],
        ];
    }
}
