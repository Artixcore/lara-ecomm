<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;

class PayPalPaymentService implements PaymentServiceInterface
{
    private string $clientId;
    private string $clientSecret;
    private string $mode;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
        $this->mode = config('services.paypal.mode', 'sandbox');
    }

    private function getAccessToken(): ?string
    {
        $url = $this->mode === 'sandbox' 
            ? 'https://api.sandbox.paypal.com/v1/oauth2/token'
            : 'https://api.paypal.com/v1/oauth2/token';

        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($url, [
                'grant_type' => 'client_credentials',
            ]);

        return $response->json()['access_token'] ?? null;
    }

    public function processPayment(array $data): array
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'error' => 'Failed to authenticate with PayPal'];
        }

        $baseUrl = $this->mode === 'sandbox'
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';

        $response = Http::withToken($accessToken)
            ->post("{$baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => strtoupper($data['currency'] ?? 'USD'),
                        'value' => number_format($data['amount'], 2, '.', ''),
                    ],
                ]],
                'application_context' => [
                    'return_url' => $data['return_url'] ?? route('payment.success'),
                    'cancel_url' => $data['cancel_url'] ?? route('payment.cancel'),
                ],
            ]);

        if ($response->successful()) {
            $order = $response->json();
            return [
                'success' => true,
                'transaction_id' => $order['id'],
                'approval_url' => collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null,
            ];
        }

        return [
            'success' => false,
            'error' => $response->json()['message'] ?? 'Payment processing failed',
        ];
    }

    public function verifyPayment(string $transactionId): bool
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return false;
        }

        $baseUrl = $this->mode === 'sandbox'
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';

        $response = Http::withToken($accessToken)
            ->get("{$baseUrl}/v2/checkout/orders/{$transactionId}");

        if ($response->successful()) {
            $order = $response->json();
            return $order['status'] === 'COMPLETED';
        }

        return false;
    }
}

