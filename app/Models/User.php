<?php

namespace Arbify\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasApiTokens;

    public const ROLES = [
        self::ROLE_SUPER_ADMINISTRATOR,
        self::ROLE_ADMINISTRATOR,
        self::ROLE_USER,
        self::ROLE_GUEST,
    ];

    public const ROLE_SUPER_ADMINISTRATOR = 3;
    public const ROLE_ADMINISTRATOR = 2;
    public const ROLE_USER = 1;
    public const ROLE_GUEST = 0;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projectMemberships(): HasMany
    {
        return $this->hasMany(ProjectMember::class);
    }

    public function isSuperAdministrator(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMINISTRATOR;
    }

    public function isAdministrator(): bool
    {
        return $this->role === self::ROLE_ADMINISTRATOR;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isGuest(): bool
    {
        return $this->role === self::ROLE_GUEST;
    }
}
