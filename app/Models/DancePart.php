<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DancePart extends Model
{
    protected $guarded = [];

    public function danceMoves(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DanceMove::class);
    }

    public function dancePartVideos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DancePartVideo::class);
    }
}
