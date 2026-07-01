<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipality extends Model
{
    protected $fillable = ['district_id', 'name', 'name_ne'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}