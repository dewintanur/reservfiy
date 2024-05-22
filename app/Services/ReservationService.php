<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{
    /**
     * Check if a cafe is available at a given time.
     *
     * @param int $cafeId
     * @param string $requestedTime
     * @return bool
     */
    public function isAvailable($cafeId, $requestedTime)
    {
        return !Reservation::where('cafe_id', $cafeId)
                           ->where('reservation_time', $requestedTime)
                           ->where('status', '!=', 'cancelled')
                           ->exists();
    }
}
