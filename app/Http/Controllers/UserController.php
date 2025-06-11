<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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

    public function placeOrder(Request $request)
    {
        $user = \Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $cart = session('cart', []);
        $metode = session('checkout_metode_pengiriman', null);
        
        if (!$cart || !$metode) {
            return redirect()->route('order.summary')->with('error', 'Data pesanan tidak ditemukan.');
        }
        
        // Begin transaction to ensure data integrity
        \DB::beginTransaction();
        
        try {
            foreach ($cart as $item) {
                // Get the category to update stock
                $category = \App\Models\Category::where('id', $item['category_id'])
                    ->where('product_id', $item['product_id'])
                    ->first();
                
                if (!$category) {
                    throw new \Exception('Kategori produk tidak ditemukan.');
                }
                
                // Check if enough stock is available
                if ($category->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak cukup untuk {$item['name']} - {$item['category_name']}. Tersedia: {$category->stock}.");
                }
                
                // Reduce the stock
                $category->stock -= $item['quantity'];
                $category->save();
                
                // Create the order
                \App\Models\Order::create([
                    'user_id' => $user->id,
                    'product_id' => $item['product_id'],
                    'metode_pengiriman' => $metode,
                    'bumbu_rasa' => $item['bumbu_rasa'] ?? '-',
                    'category' => $item['category_name'] ?? '-',
                    'quantity' => $item['quantity'],
                    'status' => 'paid',
                ]);
            }
            
            // If everything is successful, commit the transaction
            \DB::commit();
            
            // Clear the cart and checkout data
            session()->forget(['cart', 'checkout_metode_pengiriman']);
            
            return redirect()->route('order.success');
            
        } catch (\Exception $e) {
            // If something goes wrong, rollback the transaction
            \DB::rollBack();
            
            return redirect()->route('order.summary')->with('error', $e->getMessage());
        }
    }

    public function orderSuccess()
    {
        return view('user.order-success');
    }
    
    public function cancelOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $cart = session('cart', []);
        $metode = session('checkout_metode_pengiriman', null);
        
        if (!$cart || !$metode) {
            return redirect()->route('cart.view')->with('error', 'Data pesanan tidak ditemukan.');
        }
        
        foreach ($cart as $item) {
            Order::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'metode_pengiriman' => $metode,
                'bumbu_rasa' => $item['bumbu_rasa'] ?? '-',
                'category' => $item['category_name'] ?? '-',
                'quantity' => $item['quantity'],
                'status' => 'canceled',
            ]);
        }
        
        session()->forget(['cart', 'checkout_metode_pengiriman']);
        return redirect()->route('user.dashboard')->with('success', 'Pesanan telah dibatalkan.');
    }
    
    public function myOrders()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $orders = Order::with(['product', 'review'])
                      ->where('user_id', $user->id)
                      ->latest()
                      ->get()
                      ->groupBy(function($order) {
                          return $order->created_at->format('Y-m-d H:i:s');
                      });
        
        return view('user.my-orders', compact('orders'));
    }
    
    public function createReview($orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $order = Order::with('product')
                    ->where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->firstOrFail();
        
        // Check if review already exists
        $existingReview = \App\Models\Review::where('order_id', $orderId)->first();
        if ($existingReview) {
            return redirect()->route('user.my-orders')->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }
        
        return view('user.create-review', compact('order'));
    }
    
    public function storeReview(Request $request, $orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $validated = $request->validate([
            'delivery_comment' => 'required|string|min:5|max:500',
            'comment' => 'required|string|min:5|max:500',
        ]);
        
        $order = Order::with('product')
                    ->where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->firstOrFail();
        
        // Check if review already exists
        $existingReview = \App\Models\Review::where('order_id', $orderId)->first();
        if ($existingReview) {
            return redirect()->route('user.my-orders')->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }
        
        \App\Models\Review::create([
            'user_id' => $user->id,
            'product_id' => $order->product_id,
            'order_id' => $order->id,
            'delivery_comment' => $validated['delivery_comment'],
            'comment' => $validated['comment'],
        ]);
        
        return redirect()->route('user.my-orders')->with('success', 'Terima kasih atas ulasan Anda!');
    }
    
    public function showReview($orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $order = Order::with(['product', 'review'])
                    ->where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->firstOrFail();
        
        if (!$order->review) {
            return redirect()->route('user.my-orders')->with('error', 'Belum ada ulasan untuk pesanan ini.');
        }
        
        return view('user.show-review', compact('order'));
    }
}


