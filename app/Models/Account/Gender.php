<?php

namespace App\Models\Account;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';
}
