<?php

namespace App\View\Composers;

use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $view->with('menuItems', [
            [
                'route' => 'home',
                'label' => __('dashboard.routes.index'),
                'children' => ['home'],
            ],
            [
                'route' => 'users.index',
                'label' => __('users.routes.index'),
                'children' => ['users.index', 'users.create', 'users.edit'],
            ],
        ]);
    }
}
