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
                'label' => __('dashboard.routes.index'),
                'icon' => 'tabler:dashboard',
            ],
            [
                'route' => 'users.home',
                'label' => __('users.routes.index'),
                'icon' => 'tabler:users',
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
        return [];
    }
}
