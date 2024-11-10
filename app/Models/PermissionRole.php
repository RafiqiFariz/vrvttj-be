<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    public function role(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Role::class);
    }

    public function permission(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Permission::class);
    }
}
