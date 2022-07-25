<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read int $account_id
 * @property-read Account $account
 * @property-read int $setting_id
 * @property-read Metadata $setting
 * @property null|\ArrayObject $payload
 */
class Setting extends Pivot
{
    protected $table = 'account_setting';

    protected $fillable = ['payload'];

    protected $casts = [
        'payload' => AsArrayObject::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Metadata
     */
    public function setting()
    {
        return $this->belongsTo(Metadata::class, 'setting_id');
    }
}
