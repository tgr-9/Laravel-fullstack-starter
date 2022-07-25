<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property Account\MetaType $type
 * @property string $key
 * @property string $cast
 * @property null|\ArrayObject $payload
 * @property-read string $label
 * @property-read string $description
 * @property-read Account\Contact $defined_contacts
 * @property-read Account\Meta $defined_meta
 * @property-read Account\Relation $defined_relation
 * @property-read Account\Setting $defined_settings
 * @property-read Account $accounts
 * @property-read self $onlyRelations
 * @property-read self $onlySettings
 * @property-read self $onlyContacts
 *
 * @method static Builder|self onlyRelations()
 * @method static Builder|self onlySettings()
 * @method static Builder|self onlyContacts()
 * @method static \Database\Factories\AccountFactory<static> factory()
 */
class Metadata extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['type', 'key', 'cast', 'payload'];

    protected $casts = [
        'type' => Account\MetaType::class,
        'payload' => AsArrayObject::class,
    ];

    public function getLabelAttribute(): string
    {
        return trans($this->type->value.'.'.$this->key.'.label');
    }

    public function getDescriptionAttribute(): string
    {
        return trans($this->type->value.'.'.$this->key.'.description');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Account
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlyRelations(Builder $query)
    {
        return $query->where('type', Account\MetaType::Relations);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlySettings(Builder $query)
    {
        return $query->where('type', Account\MetaType::Settings);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlyContacts(Builder $query)
    {
        return $query->where('type', Account\MetaType::Contacts);
    }
}
