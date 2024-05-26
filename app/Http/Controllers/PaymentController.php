<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Services\PaymentService;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function create($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        return view('payments.create', compact('reservation'));
    }

    public function process(Request $request, $reservationId)
    {
        $validated = $request->validate([
            'discount' => 'required|integer',
            'payment_method' => 'required|string',
        ]);

        $reservation = Reservation::find($reservationId);
        
        if (!$reservation) {
            return back()->withErrors('Reservation not found.');
        }

        $result = $this->paymentService->processPayment($reservation->id, $validated['discount'], $validated['payment_method']);

        if ($result && $result['success']) {
            return redirect()->route('payments.success', ['id' => $result['payment_id']]);
        } else {
            return back()->withErrors('Payment failed. Please try again.');
        }
    }

    public function store(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        $reservation->update(['status' => 'Paid']);

        return redirect()->route('payments.success', ['id' => $reservation->id]);
    }

    public function success($reservation_id)
    {
       // Ambil data reservasi berdasarkan ID
       $reservation = Reservation::findOrFail($reservation_id);

       // Generate URL untuk barcode menggunakan API eksternal
       $barcodeUrl = "https://bwipjs-api.metafloor.com/?bcid=code128&text=" . $reservation->id . "&scale=3&includetext";

       // Kirim data ke view
       return view('payments.success', [
           'reservation' => $reservation,
           'barcodeUrl' => $barcodeUrl
       ]);
    }

    public function invoice($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return redirect()->back()->withErrors('Reservation not found.');
        }

        return view('payments.invoice', compact('reservation'));
    }
}

