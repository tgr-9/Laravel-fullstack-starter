<?php

namespace App\Models\Account;

enum MetaType: string
{
    case Contacts = 'contact';
    case Relations = 'relation';
    case Settings = 'setting';
}
