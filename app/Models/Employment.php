<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\EmploymentFactory<static> factory()
 */
class Employment extends Pivot
{
    use HasFactory;
    use SoftDeletes;
}
