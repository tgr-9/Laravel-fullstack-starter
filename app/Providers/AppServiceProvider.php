<?php

namespace App\Providers;

use App\View\Composers\NavigationsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment('local') && \class_exists('\Laravel\Telescope\TelescopeServiceProvider')) {
            app()->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            // app()->register(TelescopeServiceProvider::class);
        }
        // .
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootViewComposers();

        // .
    }

    private function bootViewComposers(): void
    {
        View::composer('*', NavigationsComposer::class);
    }
}
