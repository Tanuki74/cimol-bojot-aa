<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

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
}
