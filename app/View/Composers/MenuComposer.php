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
            ],
            [
                'route' => 'users.home',
                'label' => __('users.routes.index'),
            ],
        ]);
    }
}
