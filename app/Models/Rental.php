<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'technology_id',
        'renter_name',
        'renter_email',
        'renter_phone',
        'renter_address',
        'status',
        'rental_date',
        'rental_hours',
        'rental_days',
        'payment_amount',
        'return_date',
        'notes',
        'fully_paid',
    ];

    protected $casts = [
        'rental_date' => 'date',
        'return_date' => 'date',
    ];

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }
}
