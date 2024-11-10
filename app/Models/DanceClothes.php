<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanceClothes extends Model
{
    protected $guarded = [];

    public function dance()
    {
        return $this->belongsTo(Dance::class);
    }
}
