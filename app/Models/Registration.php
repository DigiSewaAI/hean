<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'hostel_name',
        'operator_name',
        'district',
        'municipality',
        'ward',
        'street',
        'contact',
        'documents',
        'status',
        'inspector_id'
    ];

    protected $casts = [
        'documents' => 'array', // JSON field
        'inspector_id' => 'integer',
    ];

    // Relationship: Inspector (User)
    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    // Scope for pending registrations
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved registrations
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}