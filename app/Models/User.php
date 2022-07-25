<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read int $id
 * @property string $username
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $accounts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $billings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $companies
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $family
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Account> $profiles
 *
 * @method static \Database\Factories\UserFactory<static> factory()
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'immutable_datetime',
    ];

    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = \bcrypt($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Account
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Account
     */
    public function billings()
    {
        return $this->accounts()->onlyBillings();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Account
     */
    public function companies()
    {
        return $this->accounts()->onlyCompanies();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Account
     */
    public function family()
    {
        return $this->accounts()->onlyFamily();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Account
     */
    public function profiles()
    {
        return $this->accounts()->onlyPeople();
    }
}
