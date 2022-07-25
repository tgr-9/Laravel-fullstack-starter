<?php

namespace App\Models\Employment;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Directory extends Pivot
{
    protected $table = 'emp_directories';

    public $timestamps = false;
}
