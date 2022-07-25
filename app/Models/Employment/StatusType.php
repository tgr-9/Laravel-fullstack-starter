<?php

namespace App\Models\Employment;

enum StatusType: string
{
    case Employment = 'employment';
    case Marital = 'marital';
    case Tax = 'tax';
}
