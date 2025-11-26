<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    public function switch(Request $request, string $currency)
    {
        $currencyService = new CurrencyService();
        $availableCurrencies = array_keys($currencyService->getAvailableCurrencies());
        
        if (!in_array($currency, $availableCurrencies)) {
            return redirect()->back()->with('error', 'Currency not supported');
        }

        session(['currency' => $currency]);
        
        if (Auth::check()) {
            Auth::user()->update(['currency' => $currency]);
        }

        return redirect()->back();
    }
}
