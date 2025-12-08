{{-- resources/views/warehouses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Warehouses - Product Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">🏢 Warehouses</h2>
    <a href="{{ route('warehouses.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
        <span>+</span> Add New Warehouse
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    @if($warehouses->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warehouse Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($warehouses as $warehouse)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loop->iteration + ($warehouses->currentPage() - 1) * $warehouses->perPage() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold text-gray-900">{{ $warehouse->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($warehouse->location, 80) ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <a href="{{ route('stocks.index', ['warehouse_id' => $warehouse->id]) }}" 
                               class="text-green-600 hover:text-green-900 mx-1" title="View Stock">
                                📊
                            </a>
                            <a href="{{ route('warehouses.edit', $warehouse) }}" 
                               class="text-yellow-600 hover:text-yellow-900 mx-1" title="Edit">
                                ✏️
                            </a>
                            <form action="{{ route('warehouses.destroy', $warehouse) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure? All stocks in this warehouse will be deleted!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 mx-1" title="Delete">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white px-4 py-3 border-t border-gray-200">
            {{ $warehouses->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-6xl mb-4">🏢</div>
            <p class="text-gray-500 mb-4">No warehouses found.</p>
            <a href="{{ route('warehouses.create') }}" 
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                + Add First Warehouse
            </a>
        </div>
    @endif
</div>
@endsection