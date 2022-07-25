<?php

namespace App\Models\Account;

enum Type: string
{
    case Billings = 'billings';
    case Companies = 'companies';
    case Family = 'family';
    case People = 'people';
}
