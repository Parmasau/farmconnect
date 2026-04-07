<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalFarmers = User::where('role', 'farmer')->count();
        $totalAgrovets = User::where('role', 'agrovet')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        
        $recentUsers = User::latest()->limit(5)->get();
        $recentOrders = Order::with('buyer')->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalFarmers', 'totalAgrovets', 
            'totalProducts', 'totalOrders', 'recentUsers', 'recentOrders'
        ));
    }
}