<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $newOrdersCount = Order::where('status', 'paid')->count();
        return view('admin.dashboard', compact('newOrdersCount'));
    }

    public function orders()
    {
        $pendingOrders = Order::with(['product', 'user'])->whereIn('status', ['paid', 'shipped', 'canceled'])->latest()->get();
        $completedOrders = Order::with(['product', 'user'])->where('status', 'completed')->latest()->get();
        return view('admin.orders.index', compact('pendingOrders', 'completedOrders'));
    }

    public function shipOrder(Order $order)
    {
        $order->update(['status' => 'shipped']);
        return redirect()->back()->with('success', 'Order marked as shipped successfully!');
    }

    public function completeOrder(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Order marked as completed successfully!');
    }
    
    public function reviews(Request $request)
    {
        $productId = $request->input('product_id');
        $query = Review::with(['order', 'product', 'user']);
        
        if ($productId) {
            $query->where('product_id', $productId);
        }
        
        $reviews = $query->latest()->paginate(10);
        $products = Product::orderBy('name')->get();
        
        return view('admin.reviews.index', compact('reviews', 'products', 'productId'));
    }
    
    public function transactionReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = Order::with(['product', 'user'])
                    ->orderBy('created_at', 'desc');
        
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
        }
        
        $orders = $query->get();
        
        return view('admin.reports.transactions', compact('orders', 'startDate', 'endDate'));
    }
    
    public function downloadTransactionReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Require both start and end dates
        if (!$startDate || !$endDate) {
            return redirect()->route('admin.reports.transactions')
                ->with('error', 'Tanggal awal dan akhir diperlukan untuk mengunduh laporan.');
        }
        
        $query = Order::with(['product', 'user'])
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->orderBy('created_at', 'desc');
        
        $orders = $query->get();
        
        $pdf = \PDF::loadView('admin.reports.transactions_pdf', compact('orders', 'startDate', 'endDate'));
        
        return $pdf->download('laporan-transaksi-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
