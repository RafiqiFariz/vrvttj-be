<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dance extends Model
{
    protected $guarded = [];
    protected $with = ['danceType'];

    public function danceType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DanceType::class);
    }

    public function danceMoves(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DanceMove::class);
    }

    public function danceParts(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(DancePart::class, DanceMove::class);
    }
}
