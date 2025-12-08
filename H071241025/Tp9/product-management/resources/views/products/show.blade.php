{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Product Detail')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="md:col-span-1 space-y-6">
        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-500 text-white px-6 py-4">
                <h3 class="text-lg font-bold">ℹ️ Product Information</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="text-gray-600">Name:</label>
                        <p class="font-semibold text-gray-900">{{ $product->title }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Category:</label>
                        <p>
                            @if($product->category)
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    {{ $product->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-gray-600">Price:</label>
                        <p class="text-green-600 font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Created:</label>
                        <p class="text-gray-700">{{ $product->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Updated:</label>
                        <p class="text-gray-700">{{ $product->updated_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('products.edit', $product) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition">
                        ✏️ Edit
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm transition">
                        ← Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        @if($product->detail)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h3 class="text-base font-bold text-gray-800">📋 Product Details</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="text-gray-600">Description:</label>
                        <p class="text-gray-700">{{ $product->detail->description ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Weight:</label>
                        <p class="text-gray-700">{{ $product->detail->weight }} kg</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Size:</label>
                        <p class="text-gray-700">{{ $product->detail->size ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Stock -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">📊 Stock per Warehouse</h3>
                <a href="{{ route('stocks.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition">
                    + Add Stock
                </a>
            </div>
            <div class="p-6">
                @if($product->warehouses->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Warehouse</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Stock</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($product->warehouses as $warehouse)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $warehouse->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($warehouse->location, 40) ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @php $qty = $warehouse->pivot->quantity; @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $qty > 10 ? 'bg-green-100 text-green-800' : ($qty > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $qty }} units
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-700">Total Stock:</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                            {{ $product->warehouses->sum('pivot.quantity') }} units
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-5xl mb-3">📭</div>
                        <p class="text-gray-500 mb-3">No stock in any warehouse yet.</p>
                        <a href="{{ route('stocks.create') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                            + Add Stock
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection