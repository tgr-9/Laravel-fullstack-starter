<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property null|int $user_id
 * @property null|int $photo_id
 * @property string $name
 * @property null|string $slug
 * @property null|string $display
 * @property null|string $summary
 * @property null|Account\Type $type
 * @property null|Account\Gender $gender
 * @property null|\Carbon\CarbonImmutable $deleted_at
 * @property null|\Carbon\CarbonImmutable $updated_at
 * @property null|\Carbon\CarbonImmutable $created_at
 * @property-read User $user
 * @property-read File $photo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Metadata> $metadata
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Metadata> $contacts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Metadata> $relations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Metadata> $settings
 * @property-read self $onlyBillings
 * @property-read self $onlyCompanies
 * @property-read self $onlyFamily
 * @property-read self $onlyPeople
 *
 * @method static Builder|self onlyBillings()
 * @method static Builder|self onlyCompanies()
 * @method static Builder|self onlyFamily()
 * @method static Builder|self onlyPeople()
 * @method static \Database\Factories\AccountFactory<static> factory()
 */
class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'display', 'summary'];

    protected $with = ['user', 'photo'];

    protected $casts = [
        'type' => Account\Type::class,
        'gender' => Account\Gender::class,
    ];

    public function setSlugAttribute(?string $value = null)
    {
        $this->attributes['slug'] = $value ?: Str::slug($this->attributes['name']);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlyBillings(Builder $query)
    {
        return $query->where('type', Account\Type::Billings);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlyCompanies(Builder $query)
    {
        return $query->where('type', Account\Type::Companies);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlyFamily(Builder $query)
    {
        return $query->where('type', Account\Type::Family);
    }

    /**
     * @param  Builder  $query
     * @return Builder|static
     */
    public function scopeOnlyPeople(Builder $query)
    {
        return $query->where('type', Account\Type::People);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|File
     */
    public function photo()
    {
        return $this->belongsTo(File::class, 'photo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Metadata
     */
    public function metadata()
    {
        return $this->belongsToMany(Metadata::class, 'account_meta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Metadata
     */
    public function contacts()
    {
        return $this->belongsToMany(Metadata::class, 'account_contacts')
            ->using(Account\Contact::class)
            ->withPivot(['payload', 'is_primary'])
            ->withTimestamps()
            ->as('defined_contacts');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Metadata
     */
    public function relations()
    {
        return $this->belongsToMany(Metadata::class, 'account_relation')
            ->using(Account\Relation::class)
            ->withPivot(['notes', 'related_id'])
            ->as('defined_relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Metadata
     */
    public function settings()
    {
        return $this->belongsToMany(Metadata::class, 'account_setting')
            ->using(Account\Setting::class)
            ->withPivot(['payload'])
            ->withTimestamps()
            ->as('defined_settings');
    }
}
