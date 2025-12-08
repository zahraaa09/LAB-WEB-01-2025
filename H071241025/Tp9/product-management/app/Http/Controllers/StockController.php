<?php
// app/Http/Controllers/StockController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouse = null;
        $stocks = collect();

        if ($request->has('warehouse_id') && $request->warehouse_id) {
            $selectedWarehouse = Warehouse::findOrFail($request->warehouse_id);
            
            // Eager loading dengan relasi seperti di modul
            $stocks = $selectedWarehouse->products()
                ->with(['category', 'detail'])
                ->get();
        }

        return view('stocks.index', compact('warehouses', 'selectedWarehouse', 'stocks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::with('category')->get();
        
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0',
        ]);

        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
        $product = Product::findOrFail($validated['product_id']);
        $quantity = $validated['quantity'];

        // Gunakan DB Transaction seperti di modul
        DB::transaction(function () use ($warehouse, $product, $quantity) {
            // Cek stok saat ini
            $currentStock = $warehouse->products()
                ->where('product_id', $product->id)
                ->first();

            $currentQty = $currentStock ? $currentStock->pivot->quantity : 0;
            $newQuantity = $currentQty + $quantity;

            // Validasi: stok tidak boleh minus
            if ($newQuantity < 0) {
                throw new \Exception('Stok tidak boleh minus! Stok saat ini: ' . $currentQty);
            }

            // Sync dengan quantity baru (seperti attach di modul)
            $warehouse->products()->syncWithoutDetaching([
                $product->id => ['quantity' => $newQuantity]
            ]);
        });

        $action = $quantity > 0 ? 'ditambahkan' : 'dikurangi';
        return redirect()->route('stocks.index', ['warehouse_id' => $warehouse->id])
            ->with('success', "Stok berhasil {$action}!");
    }

    public function getStock(Request $request)
    {
        $warehouse = Warehouse::find($request->warehouse_id);
        $product = $warehouse->products()
            ->where('product_id', $request->product_id)
            ->first();

        return response()->json([
            'quantity' => $product ? $product->pivot->quantity : 0
        ]);
    }
}