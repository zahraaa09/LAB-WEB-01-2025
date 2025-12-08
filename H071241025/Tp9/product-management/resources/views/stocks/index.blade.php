{{-- resources/views/stocks/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Stock Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">📊 Stock Management</h2>
    <a href="{{ route('stocks.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
        🔄 Transfer Stock
    </a>
</div>

<!-- Filter Warehouse -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form action="{{ route('stocks.index') }}" method="GET" class="flex gap-4">
        <div class="flex-1">
            <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-2">
                Select Warehouse
            </label>
            <select name="warehouse_id" 
                    id="warehouse_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    onchange="this.form.submit()">
                <option value="">-- Select Warehouse --</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" 
                            {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                🔍 View
            </button>
        </div>
    </form>
</div>

@if($selectedWarehouse)
    <!-- Warehouse Info -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold mb-1">🏢 {{ $selectedWarehouse->name }}</h3>
                <p class="text-blue-100">
                    📍 {{ $selectedWarehouse->location ?? 'Location not available' }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-blue-100 text-sm mb-1">Total Products:</p>
                <p class="text-3xl font-bold">{{ $stocks->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($stocks->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($stocks as $stock)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900">{{ $stock->title }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($stock->category)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $stock->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $stock->detail->weight ?? '-' }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($stock->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php $qty = $stock->pivot->quantity; @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $qty > 10 ? 'bg-green-100 text-green-800' : ($qty > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $qty }} units
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right font-bold text-gray-700">
                                Total Stock:
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-bold">
                                    {{ $stocks->sum('pivot.quantity') }} units
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 mb-4">No stock in this warehouse yet.</p>
                <a href="{{ route('stocks.create') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    + Add Stock
                </a>
            </div>
        @endif
    </div>
@else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <div class="text-6xl mb-4">🏢</div>
        <p class="text-gray-500">Please select a warehouse to view stock</p>
    </div>
@endif
@endsection