<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class TranslationsComposer
{
    public function compose(View $view)
    {
        $locales = [];

        foreach (File::directories(\resource_path('lang')) as $dir) {
            $trans = collect([]);

            foreach (File::files($dir) as $file) {
                $trans[\basename($file, '.php')] = require $file;
            }

            $locales[\basename($dir)] = $trans->dot()->toArray();
        }

        $view->with('translations', $locales);
    }
}
