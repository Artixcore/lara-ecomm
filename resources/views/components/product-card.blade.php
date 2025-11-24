<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <a href="{{ route('products.show', $product) }}">
        <div class="aspect-w-1 aspect-h-1 bg-gray-200 dark:bg-gray-700">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
        </div>
    </a>
    <div class="p-4">
        <a href="{{ route('products.show', $product) }}">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400">
                {{ $product->name }}
            </h3>
        </a>
        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
            {{ Str::limit($product->description, 100) }}
        </p>
        <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
            @if($product->stock > 0)
                <span class="text-sm text-green-600 dark:text-green-400">In Stock</span>
            @else
                <span class="text-sm text-red-600 dark:text-red-400">Out of Stock</span>
            @endif
        </div>
        @auth
        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4" x-data="{ loading: false }" @submit.prevent="loading = true; fetch($event.target.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ quantity: 1 }) }).then(r => r.json()).then(data => { loading = false; if(data.success) { document.getElementById('cart-count').textContent = data.cart_count; document.getElementById('cart-count-badge').textContent = data.cart_count; if(document.getElementById('cart-count-badge').textContent > 0) document.getElementById('cart-count-badge').style.display = 'flex'; } }).catch(() => loading = false); $event.target.submit();">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" :disabled="loading" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50">
                <span x-show="!loading">Add to Cart</span>
                <span x-show="loading">Adding...</span>
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
            Login to Buy
        </a>
        @endauth
    </div>
</div>

