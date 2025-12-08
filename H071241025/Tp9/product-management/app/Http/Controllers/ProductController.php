<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'detail'])->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create([
                'title' => $request->title,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            $product->detail()->create([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'detail', 'warehouses']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('detail');
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'title' => $request->title,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            $product->detail()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'description' => $request->description,
                    'weight' => $request->weight,
                    'size' => $request->size,
                ]
            );
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->warehouses()->detach();
            $product->detail()->delete();
            $product->delete();
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
