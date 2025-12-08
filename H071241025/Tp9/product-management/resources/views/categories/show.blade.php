{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Category Detail')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Category Info -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-500 text-white px-6 py-4">
                <h3 class="text-lg font-bold">ℹ️ Category Information</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-600">Name:</label>
                        <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Description:</label>
                        <p class="text-gray-700">{{ $category->description ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Total Products:</label>
                        <p><span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ $category->products->count() }}</span></p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Created:</label>
                        <p class="text-gray-700">{{ $category->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Updated:</label>
                        <p class="text-gray-700">{{ $category->updated_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <a href="{{ route('categories.edit', $category) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition">
                        ✏️ Edit
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm transition">
                        ← Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products List -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h3 class="text-lg font-bold text-gray-800">📦 Products in this Category</h3>
            </div>
            <div class="p-6">
                @if($category->products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $product->title }}</td>
                                    <td class="px-4 py-3 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="text-blue-600 hover:text-blue-900 text-sm">
                                            👁️ View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-5xl mb-3">📭</div>
                        <p class="text-gray-500">No products in this category yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection