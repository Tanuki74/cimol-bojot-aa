<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Count new orders (using 'paid' status to match the orders method)
        $newOrdersCount = Order::where('status', 'paid')->count();
        
        // Today's revenue - using the same approach as the orders page
        $todayOrders = Order::with('product.categories')
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->get();
            
        $todayRevenue = 0;
        foreach ($todayOrders as $order) {
            $cat = $order->product->categories->where('category', $order->category)->first();
            if ($cat) {
                $todayRevenue += $order->quantity * $cat->price;
            }
        }
            
        // This month's revenue - using the same approach as the orders page
        $monthlyOrders = Order::with('product.categories')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->get();
            
        $monthlyRevenue = 0;
        foreach ($monthlyOrders as $order) {
            $cat = $order->product->categories->where('category', $order->category)->first();
            if ($cat) {
                $monthlyRevenue += $order->quantity * $cat->price;
            }
        }
            
        // Last 7 days revenue for chart
        $last7DaysData = [];
        $last7DaysLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last7DaysLabels[] = $date->format('d M');
            
            // Get orders for this day using the same approach as the orders page
            $dayOrders = Order::with('product.categories')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->where('status', 'completed')
                ->get();
                
            $revenue = 0;
            foreach ($dayOrders as $order) {
                $cat = $order->product->categories->where('category', $order->category)->first();
                if ($cat) {
                    $revenue += $order->quantity * $cat->price;
                }
            }
                
            $last7DaysData[] = $revenue;
        }
        
        // Revenue by product category (for pie chart) - using the same approach as the orders page
        $completedOrders = Order::with('product.categories')
            ->where('status', 'completed')
            ->get();
        
        // Create an array to store revenue by category
        $categoryRevenues = [];
        
        foreach ($completedOrders as $order) {
            $cat = $order->product->categories->where('category', $order->category)->first();
            
            if ($cat) {
                $categoryName = $cat->category;
                $orderRevenue = $order->quantity * $cat->price;
                
                if (!isset($categoryRevenues[$categoryName])) {
                    $categoryRevenues[$categoryName] = 0;
                }
                
                $categoryRevenues[$categoryName] += $orderRevenue;
            }
        }
        
        // Convert to collection for the chart
        $revenueByCategory = collect();
        foreach ($categoryRevenues as $category => $revenue) {
            $revenueByCategory->push([
                'category' => $category,
                'revenue' => $revenue
            ]);
        }
            
        $categoryLabels = $revenueByCategory->pluck('category')->toArray();
        $categoryData = $revenueByCategory->pluck('revenue')->toArray();
        
        // Total orders count
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $canceledOrders = Order::where('status', 'canceled')->count();
        
        return view('admin.dashboard', compact(
            'newOrdersCount',
            'todayRevenue',
            'monthlyRevenue',
            'last7DaysLabels',
            'last7DaysData',
            'categoryLabels',
            'categoryData',
            'totalOrders',
            'completedOrders',
            'canceledOrders'
        ));
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
