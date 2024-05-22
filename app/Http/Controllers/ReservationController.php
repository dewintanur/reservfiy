<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Cafe;
use App\Models\Package;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use App\Notifications\ReservationNotification;

use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {

        $reservations = Reservation::all();
        return view('reservations.index', ['reservations' => $reservations]);
    }

    public function history()
    {
        $reservations = Reservation::where('user_id', auth()->id())->get();
        return view('reservations.history', compact('reservations'));
    }

    public function bookCafe(Request $request, $cafeId)
    {
    
        $validatedData = $request->validate([
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|date_format:H:i',
            'table_id' => 'required|exists:tables,id',
            'number_of_people' => 'required|integer|min:1',
            'package_id' => 'required|exists:packages,id',
        ]);
        $tableId = $request->input('table_id');
        $table = Table::findOrFail($tableId);
        
        // Save validated data into the session to be used after payment
        session([
            'reservation_data' => array_merge($validatedData, ['table_number' => $table->table_number]),
            'cafe_id' => $cafeId
        ]);

        // Redirect to payment page
        return redirect()->route('reservations.details', ['reservation_data' => $validatedData, 'cafeId' => $cafeId]);
    }

    public function showDetails(Request $request)
    {
        $reservationData = $request->session()->get('reservation_data');
        $cafeId = $request->session()->get('cafe_id');
        $cafe = Cafe::findOrFail($cafeId);
        $packages = Package::all();

        $formattedDate = Carbon::parse($reservationData['reservation_date'])->format('d M Y');
        $formattedTime = Carbon::parse($reservationData['reservation_time'])->format('H:i');
        $package = Package::findOrFail($reservationData['package_id']);

        $tax = $package->price * 0.01; // Hitung pajak sebagai 1% dari harga paket
        $total = $package->price + $tax;

        return view('reservations.detail', compact('reservationData', 'cafe', 'formattedDate', 'formattedTime', 'package', 'tax', 'total'));
    }

    public function showBookForm($cafeId)
    {
        $cafe = Cafe::findOrFail($cafeId);
        $packages = Package::all();
        $tables = Table::where('cafe_id', $cafeId)->where('status', 'available')->get(); // Get all available tables

        return view('reservations.book', compact('cafe', 'packages', 'tables'));
    }
    public function getTablesByCapacity(Request $request)
    {
        $capacity = $request->input('capacity');
        $cafeId = $request->input('cafe_id');

        $tables = Table::where('cafe_id', $cafeId)
                        ->where('capacity', '>=', $capacity)
                        ->where('status', 'available')
                        ->get();

        return response()->json($tables);
    }
    public function calculateDiscount($package, $paymentMethod)
    {
        // Contoh logika untuk menghitung diskon berdasarkan metode pembayaran
        $discount = 0;

        switch ($paymentMethod) {
            case 'cash':
                $discount = $package->price * 0.05; // Diskon 5% untuk pembayaran tunai
                break;
            case 'e_wallet':
                $discount = $package->price * 0.10; // Diskon 10% untuk pembayaran dengan e-wallet
                break;
            case 'bank_transfer':
                $discount = $package->price * 0.08; // Diskon 8% untuk pembayaran melalui transfer bank
                break;
            default:
                $discount = 0; // Tidak ada diskon
                break;
        }

        return $discount;
    }
    public function confirmPayment(Request $request)
    {
        $reservationData = $request->session()->get('reservation_data');
        $cafeId = $request->session()->get('cafe_id');
        $validatedData = $request->validate([
            'payment_method' => 'required|string',
        ]);

        $paymentMethod = $validatedData['payment_method'];
        
        if (!isset($reservationData['package_id']) || !$paymentMethod) {
            return redirect()->back()->with('error', 'Data reservasi atau metode pembayaran tidak lengkap');
        }
        
        // Proses pembayaran...
        $package = Package::findOrFail($reservationData['package_id']);
        $price = $package->price;
        $discount = $this->calculateDiscount($package, $paymentMethod);

        $finalTotal = $price - $discount;

        // Deklarasikan variabel $reservation di luar transaksi
        $reservation = null;

        DB::transaction(function () use ($reservationData, $cafeId, $finalTotal, $discount, $request, &$reservation) {
            $reservation = new Reservation([
                'id' => $this->generateReservationId(),
                'user_id' => auth()->id(),
                'cafe_id' => $cafeId,
                'reservation_date' => $reservationData['reservation_date'],
                'reservation_time' => $reservationData['reservation_time'] . ':00',
                'table_id' => $reservationData['table_id'],
                'number_of_people' => $reservationData['number_of_people'],
                'package_id' => $reservationData['package_id'],
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_method' => $request->input('payment_method'),
                'applied_discount' => $discount,
                'final_total' => $finalTotal,
            ]);

            $reservation->save();

            // Update status meja menjadi reserved
            $table = Table::find($reservationData['table_id']);
            $table->status = 'reserved';
            $table->save();

            // Cek apakah semua meja di cafe pada waktu tersebut telah dipesan
            $availableTablesCount = Table::where('cafe_id', $cafeId)
                ->where('status', 'available')
                ->count();
            
            if ($availableTablesCount == 0) {
                $cafe = Cafe::findOrFail($cafeId);
                $cafe->status = 'not available';
                $cafe->save();
            }

            $request->session()->forget(['reservation_data', 'cafe_id']);
        });
         // Buat pesan notifikasi
    $message = "Reservasi Anda untuk " . $reservationData['reservation_date'] . " pukul " . $reservationData['reservation_time'] . " berhasil!";

    // Kirim notifikasi ke pengguna
    auth()->user()->notify(new ReservationNotification($message));

        return redirect()->route('payments.success', ['reservation_id' => $reservation->id]);
    }

    private function generateReservationId()
    {
        $lastReservation = Reservation::latest('id')->first();
        if ($lastReservation) {
            $lastId = (int) substr($lastReservation->id, 3);
            $newId = $lastId + 1;
            return 'RSV' . str_pad($newId, 5, '0', STR_PAD_LEFT);
        } else {
            return 'RSV00001';
        }
    }
    public function show($id)
    {
        // Mengambil data reservasi berdasarkan ID
        $reservation = Reservation::find($id);

        // Memeriksa apakah reservasi ditemukan
        if (!$reservation) {
            // Jika tidak ditemukan, kembalikan response 404 Not Found
            abort(404);
        }

        // Mengembalikan view 'show' bersama data reservasi
        return view('payments.invoice', ['reservation' => $reservation]);
    }

}
