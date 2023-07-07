<?php

namespace App\Providers;

use App\View\Composers\NavigationsComposer;
use App\View\Composers\TranslationsComposer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

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

        if ($this->app->environment('testing') && \class_exists(Browser::class)) {
            $this->registerBuskMacroForInertia();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * While not in production, send all email tho the following address instead.
         *
         * @see https://laravel.com/docs/9.x/mail#using-a-global-to-address
         */
        if (! $this->app->environment('production') && $devMail = env('MAIL_DEVELOPMENT')) {
            Mail::alwaysTo($devMail);
        }

        View::composer('app', NavigationsComposer::class);

        View::composer('app', TranslationsComposer::class);
    }

    /**
     * Register inertia.js helper for dusk testing
     *
     * @see https://github.com/protonemedia/inertiajs-events-laravel-dusk
     */
    private function registerBuskMacroForInertia(): void
    {
        Browser::macro('waitForInertia', function (?int $seconds = null): Browser {
            /** @var Browser $this */
            $driver = $this->driver;

            $currentCount = $driver->executeScript('return window.__inertiaNavigatedCount;');

            return $this->waitUsing($seconds, 100, fn () => $driver->executeScript(
                "return window.__inertiaNavigatedCount > {$currentCount};"
            ), 'Waited %s seconds for Inertia.js to increase the navigate count.');
        });
    }
}
