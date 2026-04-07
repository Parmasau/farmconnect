<?php
// app/Services/FarmerDashboardService.php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FarmerDashboardService
{
    public function getStats()
    {
        $farmer = Auth::user();
        
        return [
            'total_products' => Product::where('farmer_id', $farmer->id)->count(),
            'available_products' => Product::where('farmer_id', $farmer->id)
                                          ->where('status', 'available')
                                          ->where('quantity', '>', 0)
                                          ->count(),
            'sold_products' => Product::where('farmer_id', $farmer->id)
                                     ->where('status', 'sold')
                                     ->count(),
            'low_stock' => Product::where('farmer_id', $farmer->id)
                                 ->where('quantity', '<', 10)
                                 ->where('quantity', '>', 0)
                                 ->count(),
            'total_orders' => Order::where('buyer_id', $farmer->id)->count(),
            'pending_orders' => Order::where('buyer_id', $farmer->id)
                                    ->where('status', 'pending')
                                    ->count(),
            'completed_orders' => Order::where('buyer_id', $farmer->id)
                                      ->where('status', 'completed')
                                      ->count(),
            'total_revenue' => Product::where('farmer_id', $farmer->id)
                                     ->where('status', 'sold')
                                     ->sum(DB::raw('price * quantity')),
        ];
    }
    
    public function getRecentProducts($limit = 5)
    {
        return Product::where('farmer_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }
    
    public function getRecentOrders($limit = 5)
    {
        return Order::where('buyer_id', Auth::id())
                    ->with('seller')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }
}