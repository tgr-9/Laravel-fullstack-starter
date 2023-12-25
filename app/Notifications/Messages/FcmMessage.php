<?php

namespace App\Notifications\Messages;

use Creasi\Base\Contracts\HasDevices;
use Illuminate\Contracts\Support\Arrayable;

class FcmMessage implements Arrayable
{
    public function __construct(
        readonly public HasDevices $user,
        readonly public string $title,
        readonly public string $body,
        readonly public Priority $priority = Priority::Normal,
    ) {
        //
    }

    /**
     * Representing fcm message structure.
     *
     * @link https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages
     */
    public function toArray(): array
    {
        return [
            'priority' => $this->priority->value,
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
            ],
            'fcm_options' => [
                'link' => \route('home'),
            ],
            'registration_ids' => $this->user->deviceTokens(),
        ];
    }
}
