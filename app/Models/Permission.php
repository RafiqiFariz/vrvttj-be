<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class)->using(PermissionRole::class);
    }
}
