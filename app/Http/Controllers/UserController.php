<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(9);
        return view('user.dashboard', compact('products'));
    }
}
