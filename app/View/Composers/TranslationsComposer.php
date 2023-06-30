<?php

namespace App\View\Composers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class TranslationsComposer
{
    public function compose(View $view)
    {
        $locales = [];

        foreach (File::directories(\resource_path('lang')) as $dir) {
            $trans = [];

            foreach (File::files($dir) as $file) {
                $trans[\basename($file, '.php')] = require $file;
            }

            $locales[\basename($dir)] = Arr::dot($trans);
        }

        $view->with('translations', $locales);
    }
}
