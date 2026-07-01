<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
    'registration_id',
    'certificate_number',
    'issued_date',
    'operator_name',
    'address',
    'contact',
    'pan',
    'pdf_path',
];


    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}