<x-admin-layout title="Reports & Analytics">
    <div class="mb-4">
        <form method="GET" class="flex items-center space-x-4">
            <label for="period" class="text-sm font-medium">Period:</label>
            <select name="period" id="period" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="day" {{ $period === 'day' ? 'selected' : '' }}>Daily</option>
                <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Weekly</option>
                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Monthly</option>
                <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Yearly</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Customer Statistics</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Customers:</span>
                    <span class="font-semibold">{{ $customerStats['total'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">New This Month:</span>
                    <span class="font-semibold">{{ $customerStats['new_this_month'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Active Customers:</span>
                    <span class="font-semibold">{{ $customerStats['active'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Sales Overview</h3>
            <p class="text-gray-600">View detailed sales reports</p>
            <a href="{{ route('admin.reports.sales') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Sales Report
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Product Performance</h3>
            <p class="text-gray-600">View top selling products</p>
            <a href="{{ route('admin.reports.products') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Products Report
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Top Products</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Sold</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($topProducts as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product['total_sold'] ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

