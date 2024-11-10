<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DancePart extends Model
{
    protected $guarded = [];

    public function danceMoves()
    {
        return $this->hasMany(DanceMove::class);
    }
}
