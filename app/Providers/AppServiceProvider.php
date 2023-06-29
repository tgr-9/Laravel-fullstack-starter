<?php

namespace App\Providers;

use App\View\Composers\MenuComposer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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

        ViewFacade::composer(['layouts.app'], MenuComposer::class);

        ViewFacade::composer('app', function (View $view) {
            $locales = [];

            foreach (File::directories(\resource_path('lang')) as $dir) {
                $trans = [];

                foreach (File::files($dir) as $file) {
                    $trans[\basename($file, '.php')] = require $file;
                }

                $locales[\basename($dir)] = Arr::dot($trans);
            }

            $view->with('translations', $locales);
        });
    }
}
