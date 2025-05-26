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
        $products = Product::latest()->with('categories')->paginate(100);
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

        $imagepath = null;
        if($request->hasFile('image')){
            $imagepath = $request->file('image')->store('gambar', 'public');
        }
        $validated['image'] = $imagepath;
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

        // Update image if new uploaded
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan gambar baru ke folder 'gambar' di disk 'public'
            $imagePath = $request->file('image')->store('gambar', 'public');
            $product->image = $imagePath;
        }

        // Update product basic info
        $product->name = $validated['name'];
        $product->save();
        
        // Update or create categories
        $existingCategories = $product->categories->pluck('id')->toArray();
        $updatedCategoryIds = [];
        
        foreach ($validated['categories'] as $i => $categoryData) {
            if (isset($product->categories[$i])) {
                // Update existing category
                $category = $product->categories[$i];
                $category->category = $categoryData['category'];
                $category->price = $categoryData['price'];
                $category->stock = $categoryData['stock'];
                $category->save();
                $updatedCategoryIds[] = $category->id;
            } else {
                // Create new category
                $category = new Category([
                    'product_id' => $product->id,
                    'category' => $categoryData['category'],
                    'price' => $categoryData['price'],
                    'stock' => $categoryData['stock']
                ]);
                $category->save();
                $updatedCategoryIds[] = $category->id;
            }
        }
        
        // Delete categories that were removed in the form
        $categoriesToDelete = array_diff($existingCategories, $updatedCategoryIds);
        if (!empty($categoriesToDelete)) {
            Category::whereIn('id', $categoriesToDelete)->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete('public/gambar/' . $product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
