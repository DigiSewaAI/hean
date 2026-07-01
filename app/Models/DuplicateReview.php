<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuplicateReview extends Model
{
    protected $fillable = [
        'registration_id',
        'reviewed_by',
        'is_duplicate',
        'notes',
        'reviewed_at',
    ];

    protected $casts = [
        'is_duplicate' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}