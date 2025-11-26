<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    private array $exchangeRates = [];
    private string $baseCurrency = 'USD';

    public function __construct()
    {
        $this->baseCurrency = setting('currency', 'USD');
        $this->loadExchangeRates();
    }

    private function loadExchangeRates(): void
    {
        // Cache exchange rates for 24 hours
        $this->exchangeRates = Cache::remember('exchange_rates', 86400, function () {
            // Using a free API (you can replace with paid API for better accuracy)
            try {
                $response = Http::get('https://api.exchangerate-api.com/v4/latest/' . $this->baseCurrency);
                
                if ($response->successful()) {
                    return $response->json()['rates'] ?? [];
                }
            } catch (\Exception $e) {
                // Fallback to static rates if API fails
            }
            
            // Fallback exchange rates (approximate)
            return [
                'USD' => 1.00,
                'EUR' => 0.92,
                'GBP' => 0.79,
                'INR' => 83.00,
                'JPY' => 149.00,
                'AUD' => 1.52,
                'CAD' => 1.36,
                'CHF' => 0.88,
                'CNY' => 7.24,
                'AED' => 3.67,
            ];
        });
    }

    public function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        // Convert to base currency first
        if ($fromCurrency !== $this->baseCurrency) {
            $rateFrom = $this->exchangeRates[$fromCurrency] ?? 1;
            $amount = $amount / $rateFrom;
        }

        // Convert to target currency
        if ($toCurrency !== $this->baseCurrency) {
            $rateTo = $this->exchangeRates[$toCurrency] ?? 1;
            $amount = $amount * $rateTo;
        }

        return round($amount, 2);
    }

    public function format(float $amount, string $currency): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'JPY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CHF' => 'CHF ',
            'CNY' => '¥',
            'AED' => 'AED ',
        ];

        $symbol = $symbols[$currency] ?? $currency . ' ';
        
        return $symbol . number_format($amount, 2);
    }

    public function getAvailableCurrencies(): array
    {
        return [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'INR' => 'Indian Rupee',
            'JPY' => 'Japanese Yen',
            'AUD' => 'Australian Dollar',
            'CAD' => 'Canadian Dollar',
            'CHF' => 'Swiss Franc',
            'CNY' => 'Chinese Yuan',
            'AED' => 'UAE Dirham',
        ];
    }

    public function getCurrentCurrency(): string
    {
        return session('currency', 
            (auth()->check() ? auth()->user()->currency : null) 
            ?? setting('currency', 'USD')
        );
    }
}

