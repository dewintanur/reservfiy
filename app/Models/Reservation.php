<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id', 
        'user_id', 
        'reservation_date', 
        'cafe_id', 
        'reservation_time', 
        'number_of_people', 
        'table_number', 
        'package_id',
        'status', 
        'payment_status', 
        'payment_method', 
        'applied_discount', 
        'final_total'
    ];

    public $incrementing = false; // Menonaktifkan auto-incrementing ID
    protected $keyType = 'string'; // Mengatur tipe kunci menjadi string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            DB::transaction(function () use ($reservation) {
                $lastReservation = static::lockForUpdate()->latest('id')->first();
                if ($lastReservation) {
                    $lastId = (int) substr($lastReservation->id, 3); // Ambil angka dari ID terakhir
                    $newId = $lastId + 1;
                    $reservation->id = 'RSV' . str_pad($newId, 5, '0', STR_PAD_LEFT); // Format ID baru
                } else {
                    $reservation->id = 'RSV00001'; // Jika tidak ada data sebelumnya, mulai dari 1
                }
            });
        });
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->reservation_date ? $this->reservation_date->format('M d, Y') : 'Date not set';
    }
}
