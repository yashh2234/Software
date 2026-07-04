<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Services\PermissionRegistrar;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'firstname',
        'lastname',
        'phone',
        'gender',
        'is_admin',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getNameAttribute(): string
    {
        return trim($this->firstname.' '.$this->lastname);
    }

    public function loginSessions(): HasMany
    {
        return $this->hasMany(LoginSession::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(LegacyGroup::class, 'user_group', 'user_id', 'group_id');
    }

    public function legacyPermissions(): array
    {
        return $this->groups
            ->flatMap(fn (LegacyGroup $group): array => $group->permissions())
            ->unique()
            ->values()
            ->all();
    }

    public function isLegacyAdmin(): bool
    {
        return $this->groups->contains(fn (LegacyGroup $group): bool => (int) $group->id === 1 || strtolower($group->group_name) === 'administrator');
    }

    // === Enterprise RBAC Methods ===

    public function roles(): MorphToMany
    {
        return $this->morphToMany(LegacyGroup::class, 'model', 'model_has_roles', 'model_id', 'role_id');
    }

    public function directPermissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }

    public function allPermissions(): array
    {
        return app(PermissionRegistrar::class)->getPermissions($this);
    }

    public function can($permission): bool
    {
        if ($this->is_admin || $this->isLegacyAdmin()) return true;
        return app(PermissionRegistrar::class)->hasPermission($this, $permission);
    }

    public function canAny(array $permissions): bool
    {
        if ($this->is_admin || $this->isLegacyAdmin()) return true;
        return app(PermissionRegistrar::class)->hasAnyPermission($this, $permissions);
    }

    public function canAll(array $permissions): bool
    {
        if ($this->is_admin || $this->isLegacyAdmin()) return true;
        return app(PermissionRegistrar::class)->hasAllPermissions($this, $permissions);
    }
}
