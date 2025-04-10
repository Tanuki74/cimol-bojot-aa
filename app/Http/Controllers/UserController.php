<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(9);
        return view('user.dashboard', compact('products'));
    }

    public function show(Product $product)
    {
        return view('user.product-detail', compact('product'));
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', 'Sorry, the requested quantity exceeds the available stock.');
        }

        // Add to session cart
        $cart = session()->get('cart', []);
        
        if(isset($cart[$validated['product_id']])) {
            $cart[$validated['product_id']]['quantity'] += $validated['quantity'];
        } else {
            $cart[$validated['product_id']] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $validated['quantity'],
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('user.dashboard')->with('success', 'Product added to cart successfully!');
    }
}
