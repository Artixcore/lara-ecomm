<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($cartItems->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4" x-data="{ quantity: {{ $item->quantity }}, loading: false }">
                                    <div class="flex items-center space-x-4 flex-1">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</h3>
                                            <p class="text-gray-600 dark:text-gray-400">${{ number_format($item->product->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" x-data @submit.prevent="loading = true; fetch($event.target.action, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ quantity: quantity }) }).then(r => r.json()).then(data => { loading = false; if(data.success) { document.getElementById('item-total-{{ $item->id }}').textContent = '$' + data.item_total; document.getElementById('cart-total').textContent = '$' + data.total; } }).catch(() => loading = false);">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" x-model="quantity" min="1" max="{{ $item->product->stock }}" class="w-20 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500" @change="$event.target.closest('form').dispatchEvent(new Event('submit'))">
                                        </form>
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white w-24 text-right" id="item-total-{{ $item->id }}">
                                            ${{ number_format($item->product->price * $item->quantity, 2) }}
                                        </span>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" x-data="{ loading: false }" @submit.prevent="loading = true; fetch($event.target.action, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } }).then(r => r.json()).then(data => { loading = false; if(data.success) { document.getElementById('cart-count').textContent = data.cart_count; document.getElementById('cart-count-badge').textContent = data.cart_count; $event.target.closest('div').remove(); if(document.querySelectorAll('[x-data*=\"quantity\"]').length === 0) location.reload(); } }).catch(() => loading = false);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" :disabled="loading" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xl font-semibold text-gray-900 dark:text-white">Total:</span>
                                <span class="text-2xl font-bold text-gray-900 dark:text-white" id="cart-total">${{ number_format($total, 2) }}</span>
                            </div>
                            <a href="{{ route('checkout.show') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-lg mb-4">Your cart is empty</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

