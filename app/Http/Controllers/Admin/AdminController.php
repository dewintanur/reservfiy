<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cafe;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->guard('admin')->check()) {
            // Admin tidak terotentikasi, arahkan ke halaman login admin
            return redirect()->route('admin.login')->with('error', 'Anda harus login sebagai admin terlebih dahulu.');
        }

        // Ambil jumlah pengguna, kafe, dan reservasi
        $userCount = User::count();
        $cafeCount = Cafe::count();
        $reservationCount = Reservation::where('status', 'active')->count();

        // Tampilkan dashboard admin dengan data yang dibutuhkan
        return view('admin.dashboard', compact('userCount', 'cafeCount', 'reservationCount'));
    }
}
