<?php

namespace App\Services\Payment;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayPaymentService implements PaymentServiceInterface
{
    private Api $api;

    public function __construct()
    {
        $this->api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    public function processPayment(array $data): array
    {
        try {
            $order = $this->api->order->create([
                'receipt' => $data['order_id'] ?? 'order_' . time(),
                'amount' => $data['amount'] * 100, // Convert to paise
                'currency' => strtoupper($data['currency'] ?? 'INR'),
            ]);

            return [
                'success' => true,
                'transaction_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function verifyPayment(string $transactionId): bool
    {
        try {
            $payment = $this->api->payment->fetch($transactionId);
            return $payment['status'] === 'authorized' || $payment['status'] === 'captured';
        } catch (\Exception $e) {
            return false;
        }
    }

    public function verifySignature(array $attributes): bool
    {
        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (SignatureVerificationError $e) {
            return false;
        }
    }
}

