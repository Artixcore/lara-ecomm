<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency(float $amount, ?string $currency = null): string
    {
        $currencyService = app(\App\Services\CurrencyService::class);
        $currency = $currency ?? $currencyService->getCurrentCurrency();
        
        return $currencyService->format($amount, $currency);
    }
}

if (!function_exists('convertCurrency')) {
    function convertCurrency(float $amount, string $fromCurrency, string $toCurrency): float
    {
        $currencyService = app(\App\Services\CurrencyService::class);
        return $currencyService->convert($amount, $fromCurrency, $toCurrency);
    }
}

