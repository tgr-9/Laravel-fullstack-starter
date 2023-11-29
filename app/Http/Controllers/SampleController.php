<?php

namespace App\Http\Controllers;

use App\Notifications\SampleNotification;
use Illuminate\Http\Request;
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

    public function firebase(Request $request)
    {
        $request->user()->notify(new SampleNotification(
            title: 'Test Notification',
            body: 'This is just test notification',
            tokens: $request->input('tokens', []),
        ));

        return \response([
            'success' => true,
            'message' => 'Notification sent',
        ], 201);
    }
}
