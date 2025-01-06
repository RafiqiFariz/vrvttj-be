<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DancePartVideo extends Model
{
    protected $guarded = [];

    public function dancePart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DancePart::class);
    }
}
