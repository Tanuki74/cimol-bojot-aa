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
            'category_id' => 'required|exists:categories,id',
            'bumbu_rasa' => 'required|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $quantity = 1;

        // Ambil kategori untuk stok dan harga
        $category = $product->categories->where('id', $validated['category_id'])->first();
        if (!$category) {
            return back()->with('error', 'Kategori tidak ditemukan.');
        }
        if ($quantity > $category->stock) {
            return back()->with('error', 'Sorry, the requested quantity exceeds the available stock.');
        }

        // Key cart unik berdasarkan product_id, category_id, bumbu_rasa
        $cartKey = $validated['product_id'].'_'.$validated['category_id'].'_'.md5($validated['bumbu_rasa']);
        $cart = session()->get('cart', []);
        
        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $product->id,
                "category_id" => $category->id,
                "name" => $product->name,
                "category_name" => $category->category,
                "bumbu_rasa" => $validated['bumbu_rasa'],
                "price" => $category->price,
                "quantity" => $quantity,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        if ($request->has('redirect_to_cart')) {
            return redirect()->route('cart.view')->with('success', 'Product added to cart successfully!');
        }
        return redirect()->route('user.dashboard')->with('success', 'Product added to cart successfully!');
    }

    public function cart()
    {
        $cart = session('cart', []);
        return view('user.cart', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        $quantities = $request->input('quantities', []);
        $cart = session('cart', []);
        $updated = false;
        foreach ($quantities as $key => $qty) {
            if (isset($cart[$key])) {
                if ($qty < 1) {
                    unset($cart[$key]);
                } else {
                    $cart[$key]['quantity'] = (int) $qty;
                }
                $updated = true;
            }
        }
        session(['cart' => $cart]);
        return redirect()->route('cart.view')->with('success', $updated ? 'Cart updated.' : 'No changes made.');
    }

    public function removeFromCart(Request $request, $key)
    {
        $cart = session('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
            return redirect()->route('cart.view')->with('success', 'Item removed from cart.');
        }
        return redirect()->route('cart.view')->with('error', 'Item not found in cart.');
    }

    public function submitCheckout(Request $request)
    {
        $request->validate([
            'metode_pengiriman' => 'required|string',
        ]);
        session(['checkout_metode_pengiriman' => $request->metode_pengiriman]);
        return redirect()->route('order.summary');
    }

    public function orderSummary(Request $request)
    {
        $cart = session('cart', []);
        $metode = session('checkout_metode_pengiriman', null);
        if (!$cart || !$metode) {
            return redirect()->route('cart.view')->with('error', 'Data pesanan tidak ditemukan.');
        }
        return view('user.order-summary', [
            'cart' => $cart,
            'metode' => $metode
        ]);
    }
}
