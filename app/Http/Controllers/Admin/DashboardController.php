<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cafe;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Anda harus login sebagai admin terlebih dahulu.');
        }

        $userCount = User::count();  // Menghitung jumlah pengguna
        $cafeCount = Cafe::count();  // Menghitung jumlah cafe
        $reservationCount = Reservation::where('status', '!=', 'booked')->count();

        // Kirim data ke view
        return view('admin.dashboard', compact('userCount', 'cafeCount', 'reservationCount'));
    }
}
