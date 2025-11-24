<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Products</a> / {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full rounded-lg">
                        @else
                            <div class="w-full h-96 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-lg">
                                <svg class="w-48 h-48 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
                        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-4">${{ number_format($product->price, 2) }}</p>
                        
                        <div class="mb-4">
                            @if($product->stock > 0)
                                <span class="inline-block bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                                    In Stock ({{ $product->stock }} available)
                                </span>
                            @else
                                <span class="inline-block bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ $product->description ?? 'No description available.' }}</p>
                        </div>

                        @auth
                        <form action="{{ route('cart.add', $product) }}" method="POST" x-data="{ quantity: 1, loading: false }" @submit.prevent="loading = true; fetch($event.target.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ quantity: quantity }) }).then(r => r.json()).then(data => { loading = false; if(data.success) { document.getElementById('cart-count').textContent = data.cart_count; document.getElementById('cart-count-badge').textContent = data.cart_count; if(document.getElementById('cart-count-badge').textContent > 0) document.getElementById('cart-count-badge').style.display = 'flex'; alert('Product added to cart!'); } }).catch(() => loading = false); $event.target.submit();">
                            @csrf
                            <div class="flex items-center gap-4 mb-4">
                                <label for="quantity" class="text-gray-700 dark:text-gray-300 font-medium">Quantity:</label>
                                <input type="number" id="quantity" x-model="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-20 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <button type="submit" :disabled="loading || {{ $product->stock }} === 0" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!loading">Add to Cart</span>
                                <span x-show="loading">Adding...</span>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center">
                            Login to Purchase
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

