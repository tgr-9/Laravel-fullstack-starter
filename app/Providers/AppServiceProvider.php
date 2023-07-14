<?php

namespace App\Providers;

use App\View\Composers\NavigationsComposer;
use App\View\Composers\TranslationsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            // $this->app->register(TelescopeServiceProvider::class);
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

        Inertia::setRootView('creasico::app');

        // .
    }

    /**
     * Register inertia.js helper for dusk testing
     *
     * @see https://github.com/protonemedia/inertiajs-events-laravel-dusk
     */
    private function bootViewComposers(): void
    {
        View::composer('*', NavigationsComposer::class);

        View::composer('*', TranslationsComposer::class);
    }
}
