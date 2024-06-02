<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Cafe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'location', 
        'operational_hours', 
        'maps_link', 
        'photo', 
        'menu', 
        'rating', 
        'social_media', 
        'status', 
        'is_available'
    ];

    // Automatically cast social_media as array
    protected $casts = [
        'social_media' => 'array'
    ];

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cafe_category');
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    // Accessors
    public function getLowestPackagePriceAttribute()
    {
        return $this->packages->min('price');
    }

    // Methods
    public function isAvailable($requestedTime)
    {
        Log::info("Memeriksa ketersediaan untuk kafe: " . $this->id . " pada " . $requestedTime);
    
        // Konversi status ke huruf kecil dan periksa apakah status sesuai
        $normalizedStatus = strtolower($this->status);
        if (!in_array($normalizedStatus, ['available', 'avalaible'])) {
            Log::info("Kafe tidak tersedia karena statusnya bukan 'Available' atau 'avalaible'. Status saat ini: " . $this->status);
            return false;
        }
    
        // Cek apakah ada reservasi yang bentrok
        $isBooked = Reservation::where('cafe_id', $this->id)
            ->where('reservation_date', $requestedTime->format('Y-m-d'))
            ->where('reservation_time', $requestedTime->format('H:i:s'))
            ->where('status', '=', 'booked')
            ->exists();
    
        Log::info("Cek apakah ada reservasi yang sudah dibooking: " . $isBooked);
        if ($isBooked) {
            Log::info("Kafe tidak tersedia karena ada reservasi yang sudah dibooking pada waktu yang diminta.");
            return false;
        }
    
        Log::info("Kafe tersedia.");
        return true;
    }
    
    public function isBookable()
    {
        // Assuming 'can_book' is a column in the database that determines the booking capability
        return $this->can_book;
    }
}
