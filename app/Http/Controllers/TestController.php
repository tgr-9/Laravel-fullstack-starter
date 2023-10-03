<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class TestController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function __invoke()
    {
        return Inertia::render('test');
    }
}
