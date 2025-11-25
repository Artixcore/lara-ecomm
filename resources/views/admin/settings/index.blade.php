<x-admin-layout title="Settings">
    <div class="max-w-4xl">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <div class="bg-white rounded-lg shadow p-6 space-y-6">
                <h3 class="text-lg font-semibold">General Settings</h3>

                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                    <input type="text" name="site_name" id="site_name" value="{{ setting('site_name', config('app.name')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="site_email" class="block text-sm font-medium text-gray-700">Site Email</label>
                    <input type="email" name="site_email" id="site_email" value="{{ setting('site_email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="site_phone" class="block text-sm font-medium text-gray-700">Site Phone</label>
                    <input type="text" name="site_phone" id="site_phone" value="{{ setting('site_phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="site_address" class="block text-sm font-medium text-gray-700">Site Address</label>
                    <textarea name="site_address" id="site_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ setting('site_address') }}</textarea>
                </div>

                <h3 class="text-lg font-semibold pt-4 border-t">Currency Settings</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                        <input type="text" name="currency" id="currency" value="{{ setting('currency', 'USD') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="currency_symbol" class="block text-sm font-medium text-gray-700">Currency Symbol</label>
                        <input type="text" name="currency_symbol" id="currency_symbol" value="{{ setting('currency_symbol', '$') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="tax_rate" class="block text-sm font-medium text-gray-700">Tax Rate (%)</label>
                    <input type="number" step="0.01" name="tax_rate" id="tax_rate" value="{{ setting('tax_rate', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>

