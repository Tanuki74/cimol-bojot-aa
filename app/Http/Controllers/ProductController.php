<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->with('categories')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array',
            'categories.*.category' => 'required|string',
            'categories.*.price' => 'required|numeric|min:0',
            'categories.*.stock' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/products', $imageName);
            $validated['image'] = str_replace('public/', '', $path);
        }

        $product = Product::create($validated);

        foreach ($validated['categories'] as $category) {
            Category::create([
                'product_id' => $product->id,
                'category' => $category['category'],
                'price' => $category['price'],
                'stock' => $category['stock']
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array',
            'categories.*.category' => 'required|string',
            'categories.*.price' => 'required|numeric|min:0',
            'categories.*.stock' => 'required|integer|min:0'
        ]);

        // Delete old image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $validated['image'] = $imageName;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
    public function daftarProduk()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('Tugas.Fisoh.menampilkanproduk', compact('products'));
    }
}
