<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanceMove extends Model
{
    protected $fillable = ['id', 'dance_id', 'dance_part_id', 'name', 'picture', 'description'];

    public function dance(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Dance::class);
    }

    public function dancePart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DancePart::class);
    }
}
