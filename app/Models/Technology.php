<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'status',
        'total_quantity',
        'available_quantity',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function getPendingCount()
    {
        return $this->rentals()->where('status', 'pending')->count();
    }

    public function getFixingCount()
    {
        return $this->rentals()->where('status', 'fixing')->count();
    }

    public function getAvailableCount()
    {
        return $this->available_quantity;
    }
}
