<?php

namespace App\Services\Payment;

interface PaymentServiceInterface
{
    public function processPayment(array $data): array;
    public function verifyPayment(string $transactionId): bool;
}

