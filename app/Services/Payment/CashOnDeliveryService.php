<?php

namespace App\Services\Payment;

class CashOnDeliveryService implements PaymentServiceInterface
{
    public function processPayment(array $data): array
    {
        // COD doesn't require actual payment processing
        return [
            'success' => true,
            'transaction_id' => 'COD_' . time(),
            'status' => 'pending',
            'message' => 'Order will be paid on delivery',
        ];
    }

    public function verifyPayment(string $transactionId): bool
    {
        // COD verification happens when order is delivered
        return str_starts_with($transactionId, 'COD_');
    }
}

