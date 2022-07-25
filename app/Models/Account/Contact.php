<?php

namespace App\Models\Account;

use App\Models\Account;
use App\Models\Metadata;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read int $id
 * @property-read int $account_id
 * @property-read Account $account
 * @property-read int $field_id
 * @property-read Metadata $field
 * @property null|\ArrayObject $payload
 * @property bool $is_primary
 */
class Contact extends Pivot
{
    protected $table = 'account_contacts';

    protected $fillable = ['payload', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
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
    public function field()
    {
        return $this->belongsTo(Metadata::class, 'field_id');
    }

    public function markAsPrimary(bool $primary = true)
    {
        return $this->update(['is_primary' => $primary]);
    }
}
