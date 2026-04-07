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
        $totalUsers = User::count();
        $totalFarmers = User::where('role', 'farmer')->count();
        $totalAgrovets = User::where('role', 'agrovet')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        return view('admin.reports.index', compact(
            'totalUsers', 'totalFarmers', 'totalAgrovets',
            'totalProducts', 'totalOrders', 'totalRevenue'
        ));
    }
}