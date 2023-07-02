<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('account/settings');
    }

    /**
     * @return \Inertia\Response
     */
    public function store()
    {
        return Inertia::render('account/settings');
    }
}
