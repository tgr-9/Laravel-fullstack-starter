<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $response = Http::asJson()->withHeaders([
            'Authorization' => 'key='.env('FIREBASE_SERVER_KEY'),
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'content_available' => true,
            'priority' => 'normal',
            'notification' => [
                'title' => 'Test Notification',
                'body' => 'This is just test notification',
            ],
            'registration_ids' => $request->input('tokens', []),
        ]);

        return $response;
    }
}
