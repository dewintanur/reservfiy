<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class Cafe extends Model
{
    protected $fillable = ['name', 'description', 'location', 'operational_hours', 'maps_link', 'photo', 'menu', 'rating', 'social_media', 'status', 'is_available'];

    // If you are storing social_media as JSON and want to automatically cast it when retrieving
    protected $casts = [
        'social_media' => 'array'
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cafe_category');
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
    public function getLowestPackagePriceAttribute()
{
    return $this->packages->min('price');
}
    public function isAvailable($requestedTime)
    {
        Log::info("Checking availability for cafe: " . $this->id . " at " . $requestedTime);
        if (!$this->is_available || $this->status !== 'Available') {
            Log::info("Cafe is not available or status is not 'Available'.");
            return false;
        }
    
        $exists = Reservation::where('cafe_id', $this->id)
             ->where(function ($query) use ($requestedTime) {
                 $query->where('reservation_date', $requestedTime->format('Y-m-d'))
                       ->where('reservation_time', $requestedTime->format('H:i:s'));
             })
             ->where('status', '!=', 'booked')
             ->exists();
    
        Log::info("Reservation conflict exists: " . $exists);
        return !$exists;
    }
    public function isBookable()
    {
        // Contoh: Misalkan 'can_book' adalah kolom di database yang menentukan kemampuan reservasi
        return $this->can_book;
    }
// Dalam model Cafe
public function reservations()
{
    return $this->hasMany(Reservation::class);
}
public function tables()
{
    return $this->hasMany(Table::class);
}
}
