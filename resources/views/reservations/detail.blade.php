@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">

<div id="qrcode"></div>

<div class="container py-5">
    <div class="row justify-content-center">
        <h1 class="mb-5 mt-2">Detail Pesanan</h1>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-20">
                <div class="py-3 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>{{ $cafe->name }}, {{ $cafe->location }}</h4>
                        <p class="mb-0"></p>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Order By</strong></p>
                    <p>{{ auth()->user()->name }}</p>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Date<i class="bi bi-calendar px-2"></i></strong></p>
                            <p>{{ $formattedDate }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Time<i class="bi bi-clock px-2"></i></strong></p>
                            <p>{{ $formattedTime }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>How Many<i class="bi bi-person-fill px-2"></i></strong></p>
                            <p>{{ $reservationData['number_of_people'] }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Number of Table<i class="bi bi-table px-2"></i></strong></p>
                            <p>{{ $reservationData['table_number'] }}</p>
                        </div>
                    </div>
                    <p><strong>Additional:</strong></p>
                    <ul>
                        <li>{{ $package->name }} - {{ $package->description }}</li>
                    </ul>
                </div>
            </div>
        </div>

       <div class="col-lg-6 px-4 py-6">
    <form onsubmit="event.preventDefault(); showPaymentModal();" class="card shadow-sm border-0">
        @csrf
        <input type="hidden" name="applied_discount" id="applied_discount" value="0">
        <input type="hidden" name="final_total" id="final_total" value="{{ $total }}">
        <div class="card shadow-sm border-0">
            <div class="py-3 px-3">
                <h4 class="fw-bold">Payment Summary</h4>
            </div>
            <div class="card-body mb-5">
                <div class="mb-3 d-flex align-items-center">
                    <strong>Harga</strong>
                    <span class="ms-auto">Rp {{ number_format($package->price, 2) }}</span>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <strong>Tax (1%)</strong>
                    <span class="ms-auto">Rp {{ number_format($package->price * 0.01, 2) }}</span>
                </div>
                <div class="mb-3 shadow-sm">
    <label for="discount" class="form-label">Select Discount</label>
    <select class="form-select rounded-3" id="discount" name="discount" onchange="updateTotal()">
        <option value="0">Tanpa Diskon</option>
        <option value="10">Diskon 10%</option>
        <option value="20">Diskon 20%</option>
    </select>
</div>
<div class="mb-3  d-flex align-items-center">
    <strong>Total</strong>
    <span class="ms-auto" id="total">Rp {{ number_format($total, 2) }}</span>
</div>
<div class="mb-3 shadow-sm">
    <label for="payment-method" class="form-label">Payment Method</label>
    <select class="form-select rounded-3" id="payment-method" name="payment_method" onchange="updatePaymentModal()">
        <option selected>Pilih Metode Pembayaran</option>
        <option value="cash">Cash</option>
        <option value="e_wallet">E-Wallet</option>
        <option value="bank_transfer">Transfer Bank</option>
    </select>
</div>

            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-lg rounded-pill px-4" style="color:white; font-weight:semibold;background-color: #DC7C41;">Payment</button>
        </div>
    </form>
</div>

    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="paymentModalBody">
                <!-- Dynamic content goes here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-brown" onclick="confirmPayment()">Confirm Payment</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>

<script>
    
    function updateTotal() {
        const basePrice = parseFloat({{ $package->price }});  // Harga asli dari package
        const tax = parseFloat({{ $tax }});                   // Pajak yang dikenakan
        const discountPercentage = parseFloat(document.getElementById('discount').value);

        const discountAmount = basePrice * (discountPercentage / 100);
        const total = basePrice + tax - discountAmount;

        document.getElementById('total').innerText = 'Rp ' + total.toFixed(2);
        document.getElementById('applied_discount').value = discountPercentage;
        document.getElementById('final_total').value = total.toFixed(2);
    }
    function updatePaymentModal() {
        const paymentMethod = document.getElementById('payment-method').value;
        const paymentModalBody = document.getElementById('paymentModalBody');
        let modalContent = '';

        if (paymentMethod === 'e_wallet') {
            const qrData = 'https://www.instagram.com/reservfiy?igsh=dHptcXRsa2JoaGVm'; // Ganti dengan variabel yang sesuai
            const qrImageUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${qrData}&size=200x200`;

            modalContent = `
                <p class="mb-3">Pay using E-Wallet</p>
                <p class="text-center">Scan the QR code or enter the payment code displayed below:</p>

                <div class="text-center mb-4">
                    <img src="${qrImageUrl}" alt="QR Code" style="max-width: 100%;">
                </div>
            `;
        } else if (paymentMethod === 'bank_transfer') {
            modalContent = `
                <div class="payment-method-info">
                    <p class="mb-3">Pay via Bank Transfer</p>
                    <p>Please transfer the total amount to the following bank account:</p>
                    <p>Bank: Bank ABC</p>
                    <p>Account Number: 123456789</p>
                    <p class="amount">Amount: Rp ${document.getElementById('total').innerText}</p>
                </div>
            `;
        } else {
            modalContent = `
                <div class="payment-method-info">
                    <p class="mb-3">Pay using Cash</p>
                    <p>Please prepare the exact amount of cash.</p>
                    <p class="amount">Amount: Rp ${document.getElementById('total').innerText}</p>
                </div>
            `;
        }

        paymentModalBody.innerHTML = modalContent;
    }

    function showPaymentModal() {
        updatePaymentModal();
        $('#paymentModal').modal('show');
    }

    function confirmPayment() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("reservations.confirmPayment") }}';
        form.innerHTML = `
            @csrf
            <input type="hidden" name="applied_discount" value="${document.getElementById('applied_discount').value}">
            <input type="hidden" name="final_total" value="${document.getElementById('final_total').value}">
            <input type="hidden" name="payment_method" value="${document.getElementById('payment-method').value}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
</script>

<style>
    .btn-brown {
        background-color: #8B4513 !important;
        color: white !important;
    }

    .btn-brown:hover {
        background-color: #A0522D;
    }
    #qrcode {
        text-align: center;
    }

    #qrcode img {
        display: inline-block;
        justify-content: center;
    }
    .payment-method-info {
        background-color: #f8f9fa; /* Warna latar belakang */
        border-radius: 10px; /* Sudut pembulatan */
        padding: 20px; /* Padding */
        margin-bottom: 20px; /* Margin bawah */
    }

    .payment-method-info p {
        margin-bottom: 10px; /* Margin bawah setiap paragraf */
    }

    .payment-method-info p:last-child {
        margin-bottom: 0; /* Hapus margin bawah untuk paragraf terakhir */
    }

    .payment-method-info .amount {
        font-weight: bold; /* Teks tebal */
    }
    
</style>
@endsection

