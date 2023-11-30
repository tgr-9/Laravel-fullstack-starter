<?php

namespace App\Notifications\Messages;

use Illuminate\Contracts\Support\Arrayable;

class FcmMessage implements Arrayable
{
    public const PRIORITY_NORMAL = 'normal';

    public const PRIORITY_HIGH = 'high';

    public function __construct(
        readonly public string $title,
        readonly public string $body,
        readonly public array $tokens,
        readonly public string $priority = self::PRIORITY_NORMAL,
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
            'priority' => $this->priority,
            'notification' => [
                'title' => $this->title,
                'body' => $this->body,
            ],
            'fcm_options' => [
                'link' => \route('home'),
            ],
            'registration_ids' => $this->tokens,
        ];
    }
}
