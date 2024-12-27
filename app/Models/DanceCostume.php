<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanceCostume extends Model
{
    protected $guarded = [];

    public function dance()
    {
        return $this->belongsTo(Dance::class);
    }
}
