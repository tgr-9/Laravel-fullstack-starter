<?php

namespace App\Notifications\Channels;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class FcmChannel
{
    public const ENDPOINT = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Send the given notification.
     *
     * @param  \App\Notifications\SampleNotification  $notification
     */
    public function send(User $notifiable, $notification): void
    {
        $message = $notification->toFcm($notifiable);

        Http::asJson()->withHeaders([
            'Authorization' => 'key='.env('FIREBASE_SERVER_KEY'),
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'priority' => $message->priority,
            'notification' => [
                'title' => $message->title,
                'body' => $message->body,
            ],
            'fcm_options' => [
                'link' => \route('home'),
            ],
            'registration_ids' => $message->tokens,
        ]);
    }
}
