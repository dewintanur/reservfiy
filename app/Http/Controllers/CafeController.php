<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Http\Request;
use App\Services\ReservationService;


class CafeController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function checkAvailability(Request $request, $cafeId)
    {
        $available = $this->reservationService->isAvailable($cafeId, $request->input('date_time'));
        return response()->json(['available' => $available]);
    }
    public function index()
    {
        $cafes = Cafe::with('packages')->get();
        $cafes = Cafe::all()->map(function ($cafe) {
            $cafe->is_bookable = $cafe->isBookable();
            return $cafe;
        });

        return view('cafes.index', ['cafes' => $cafes]);
    }

    public function show(Cafe $cafe)
    {
        $hours = json_decode($cafe->operational_hours, true);
        
        // Check if $hours is an array before proceeding
        if (is_array($hours)) {
            $formattedHours = array_map(function ($dayInfo) {
                return "{$dayInfo['day']}: {$dayInfo['open']} - {$dayInfo['close']}";
            }, $hours);
            $formattedHoursString = implode(", ", $formattedHours);
        } else {
            // Handle the case where $hours is not an array (e.g., null or invalid JSON)
            $formattedHoursString = "Not available";
        }
        
        return view('cafes.show', compact('cafe', 'formattedHoursString'));
    }
    public function search(Request $request)
    {
        $query = Cafe::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%');
            });
        }

        $cafes = $query->get();

        return view('cafes.index', compact('cafes'));
    }
    
    // public function updateCafeStatus()
    // {
    //     $cafes = Cafe::with('reservations')->get();

    //     foreach ($cafes as $cafe) {
    //         $activeReservation = $cafe->reservations()->where('status', 'booked')->exists();

    //         if ($activeReservation) {
    //             $cafe->update(['status' => 'booked']);
    //         } else {
    //             $cafe->update(['status' => 'available']);
    //         }
    //     }

    //     return back()->with('success', 'Cafe statuses updated successfully.');
    // }
}
