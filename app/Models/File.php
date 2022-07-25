<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read string $id
 * @property string $name
 * @property int $size
 * @property string $path
 * @property string $mime
 * @property string $type
 * @property null|string $url
 * @property null|\ArrayObject $meta
 * @property null|string $disk
 *
 * @method static \Database\Factories\FileFactory<static> factory()
 */
class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'files_uploaded';

    protected $fillable = ['name', 'size', 'path', 'type', 'disk', 'meta'];

    protected $casts = [
        'size' => 'number',
        'meta' => AsArrayObject::class,
    ];
}
