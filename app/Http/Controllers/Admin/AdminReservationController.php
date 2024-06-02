<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Cafe;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['user', 'cafe'])->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservation::with(['user', 'cafe'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('admin.reservations.edit', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        // Update reservation details
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_time = $request->input('reservation_time');
        $reservation->status = $request->input('status');
        $reservation->save();

        // If the reservation is completed or cancelled, update the table status
        if (in_array($reservation->status, ['completed', 'cancelled'])) {
            $table = $reservation->table;
            $table->status = 'available';
            $table->save();

            // Check if all tables in the cafe are available
            $cafe = $reservation->cafe;
            $allTablesAvailable = $cafe->tables()->where('status', '!=', 'available')->count() === 0;

            if ($allTablesAvailable) {
                $cafe->status = 'available';
                $cafe->save();
            }
        }

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
