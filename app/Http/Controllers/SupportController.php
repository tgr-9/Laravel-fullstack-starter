<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SupportController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function __invoke()
    {
        return Inertia::render('supports');
    }
}
