<x-admin-layout title="Customer: {{ $customer->name }}">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Order History</h3>
                <div class="space-y-4">
                    @forelse($customer->orders as $order)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-medium">Order #{{ $order->id }}</h4>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">${{ number_format($order->total_amount, 2) }}</p>
                                <span class="px-2 py-1 text-xs rounded-full {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">No orders found</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Customer Details</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ $customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $customer->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Orders</p>
                        <p class="font-medium">{{ $customer->orders->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="font-medium">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

