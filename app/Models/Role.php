<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get formatted name
     */
    public function getFormattedNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->name));
    }

    /**
     * Get the users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->morphedByMany(
            config('permission.models.user', 'App\Models\User'),
            'model',
            config('permission.table_names.model_has_roles'),
            'role_id',
            config('permission.column_names.model_morph_key')
        );
    }

    /**
     * Get grouped permissions
     */
    public function getGroupedPermissionsAttribute(): array
    {
        return $this->permissions->groupBy('group')->toArray();
    }

    /**
     * Check if role is admin
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Check if role is deletable
     */
    public function getIsDeletableAttribute(): bool
    {
        return !$this->is_admin && !$this->users()->exists();
    }

    /**
     * Check if role name is editable
     */
    public function getIsNameEditableAttribute(): bool
    {
        return !$this->is_admin;
    }

    /**
     * Scope a query to exclude admin role.
     */
    public function scopeExcludeAdmin($query)
    {
        return $query->where('name', '!=', 'admin');
    }

    /**
     * Scope a query to order roles by name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }
}
