<?php

namespace App\Services;

class PaymentService
{
    public function processPayment($reservationId, $discount, $paymentMethod)
    {
        // Add your payment processing logic here
        // This is a simplified version
        try {
            // Assume $paymentId is retrieved from the payment processing logic
            $paymentId = rand(); // Dummy payment ID for demonstration
            return ['success' => true, 'payment_id' => $paymentId];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
