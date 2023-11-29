<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SampleController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function __invoke()
    {
        return Inertia::render('sample/index');
    }
}
