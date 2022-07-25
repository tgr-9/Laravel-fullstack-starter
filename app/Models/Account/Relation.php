<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read int $account_id
 * @property-read Account $account
 * @property-read int $related_id
 * @property-read Account $related
 * @property-read int $relationship_id
 * @property-read Metadata $relationship
 * @property string $notes
 */
class Relation extends Pivot
{
    public $timestamps = false;

    protected $table = 'account_relation';

    protected $fillable = ['notes'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Account
     */
    public function related()
    {
        return $this->belongsTo(Account::class, 'related_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Metadata
     */
    public function relationship()
    {
        return $this->belongsTo(Metadata::class, 'relationship_id');
    }
}
