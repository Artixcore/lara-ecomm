@php
    $currencyService = new \App\Services\CurrencyService();
    $currentCurrency = $currencyService->getCurrentCurrency();
    $currencies = $currencyService->getAvailableCurrencies();
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 text-gray-700 hover:text-gray-900">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>{{ $currentCurrency }}</span>
    </button>
    
    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 max-h-64 overflow-y-auto">
        @foreach($currencies as $code => $name)
        <a href="{{ route('currency.switch', $code) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentCurrency === $code ? 'bg-gray-100' : '' }}">
            <div class="flex justify-between">
                <span>{{ $name }}</span>
                <span class="font-semibold">{{ $code }}</span>
            </div>
        </a>
        @endforeach
    </div>
</div>

