<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SampleNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private string $title,
        private string $body,
        private array $tokens,
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(User $notifiable): array
    {
        return [
            Channels\FcmChannel::class,
            'database',
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toFcm(User $notifiable): Messages\FcmMessage
    {
        return new Messages\FcmMessage($this->title, $this->body, $this->tokens);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(User $notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'deviceTokens' => $this->tokens,
        ];
    }
}
