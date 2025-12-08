{{-- resources/views/stocks/transfer.blade.php --}}
@extends('layouts.app')

@section('title', 'Transfer Stock')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-600 text-white px-6 py-4">
            <h2 class="text-xl font-bold">🔄 Transfer Stock</h2>
        </div>
        
        <div class="p-6">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-sm text-blue-700">
                    ℹ️ <strong>Info:</strong> Use positive numbers (+10) to add stock, or negative numbers (-10) to reduce stock.
                </p>
            </div>

            <form action="{{ route('stocks.store') }}" method="POST" id="stockForm">
                @csrf

                <div class="mb-4">
                    <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Warehouse <span class="text-red-500">*</span>
                    </label>
                    <select name="warehouse_id" 
                            id="warehouse_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('warehouse_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Select Warehouse --</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Product <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" 
                            id="product_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('product_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->title }} - {{ $product->category->name ?? 'No Category' }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="currentStockInfo" class="bg-gray-100 border border-gray-300 rounded-lg p-4 mb-4 hidden">
                    <p class="text-sm text-gray-700">
                        <strong>📊 Current Stock:</strong> 
                        <span id="currentStock" class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-semibold">0</span> units
                    </p>
                </div>

                <div class="mb-6">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity" 
                           value="{{ old('quantity') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('quantity') border-red-500 @enderror"
                           placeholder="e.g., +10 (add) or -10 (reduce)"
                           required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-2">
                        💡 Positive number to add stock, negative to reduce
                    </p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                        ✓ Process Transfer
                    </button>
                    <a href="{{ route('stocks.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition">
                        ✖️ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update current stock when warehouse or product changes
    document.addEventListener('DOMContentLoaded', function() {
        const warehouseSelect = document.getElementById('warehouse_id');
        const productSelect = document.getElementById('product_id');
        const currentStockInfo = document.getElementById('currentStockInfo');
        const currentStockSpan = document.getElementById('currentStock');

        function updateCurrentStock() {
            const warehouseId = warehouseSelect.value;
            const productId = productSelect.value;

            if (warehouseId && productId) {
                fetch(`{{ route('stocks.getStock') }}?warehouse_id=${warehouseId}&product_id=${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        currentStockSpan.textContent = data.quantity;
                        currentStockInfo.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        currentStockInfo.classList.add('hidden');
                    });
            } else {
                currentStockInfo.classList.add('hidden');
            }
        }

        warehouseSelect.addEventListener('change', updateCurrentStock);
        productSelect.addEventListener('change', updateCurrentStock);
    });
</script>
@endpush