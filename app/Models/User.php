<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'citizenship_number',
        'pan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ============================================================
    // RELATIONSHIPS (for Owner Dashboard)
    // ============================================================

    public function hostels()
    {
        return $this->hasMany(Hostel::class, 'owner_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'owner_id');
    }

    // Documents through registrations (or directly if you have a user_documents table, but we use registration)
    public function documents()
    {
        return $this->hasManyThrough(Document::class, Registration::class, 'owner_id', 'registration_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Registration::class, 'owner_id', 'registration_id');
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Registration::class, 'owner_id', 'registration_id');
    }

    public function certificates()
    {
        return $this->hasManyThrough(Certificate::class, Registration::class, 'owner_id', 'registration_id');
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOwner()
    {
        return $this->role === 'owner';
    }
}