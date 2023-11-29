<?php

namespace App\Notifications\Messages;

class FcmMessage
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
}
