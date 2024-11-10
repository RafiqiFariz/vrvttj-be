<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->using(PermissionRole::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }
}
