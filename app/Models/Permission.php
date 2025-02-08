<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
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
        'group',
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
     * Get formatted group
     */
    public function getFormattedGroupAttribute(): string
    {
        return ucwords($this->group);
    }

    /**
     * Get clean name without group prefix
     */
    public function getCleanNameAttribute(): string
    {
        return ucwords(str_replace(['_', $this->group . '_'], ['', ''], $this->name));
    }

    /**
     * Scope a query to filter permissions by group.
     */
    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope a query to order permissions by group and name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('group')->orderBy('name');
    }
}
