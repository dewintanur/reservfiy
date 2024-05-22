<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log; // Import Log facade

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cafes = Cafe::latest()->take(5)->get();
        $reservations = Reservation::with(['user', 'cafe'])->latest()->take(10)->get();

        // Iterate over each reservation to ensure each has a valid date
        foreach ($reservations as $reservation) {
            if ($reservation->date) {
                Log::info('Reservation date:', ['date' => $reservation->date->format('M d, Y')]); // Log date for debugging
            } else {
                Log::error('Missing date for reservation:', ['reservation_id' => $reservation->id]); // Log error if date is missing
            }
        }

        return view('home', compact('cafes', 'reservations'));
    }
}
