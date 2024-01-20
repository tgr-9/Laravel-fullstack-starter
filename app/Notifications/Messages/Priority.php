<?php

namespace App\Notifications\Messages;

enum Priority: string
{
    case Normal = 'normal';
    case High = 'high';
}
