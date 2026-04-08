<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // User Statistics
        $totalUsers = User::count();
        $totalFarmers = User::where('role', 'farmer')->count();
        $totalAgrovets = User::where('role', 'agrovet')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Product Statistics
        $totalProducts = Product::count();
        
        // Order Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Recent Data
        $recentUsers = User::latest()->limit(5)->get();
        $recentOrders = Order::with('buyer')->latest()->limit(5)->get();
        
        return view('admin.reports.index', compact(
            'totalUsers', 'totalFarmers', 'totalAgrovets', 'totalAdmins',
            'totalProducts', 'totalOrders', 'pendingOrders', 'processingOrders',
            'completedOrders', 'cancelledOrders', 'totalRevenue',
            'recentUsers', 'recentOrders'
        ));
    }
}