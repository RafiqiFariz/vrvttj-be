<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanceType extends Model
{
    protected $guarded = [];

    public function danceMoves(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DanceMove::class);
    }
}
