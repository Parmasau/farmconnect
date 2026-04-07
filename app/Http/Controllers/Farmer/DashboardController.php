<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\AdviceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $farmer = Auth::user();
        
        // Determine which column to use for products
        $foreignKey = Schema::hasColumn('products', 'farmer_id') ? 'farmer_id' : 'user_id';
        
        // Get statistics
        $stats = [
            'total_products' => Product::where($foreignKey, $farmer->id)->count(),
            'available_products' => Product::where($foreignKey, $farmer->id)
                                          ->where('status', 'available')
                                          ->where('quantity', '>', 0)
                                          ->count(),
            'sold_products' => Product::where($foreignKey, $farmer->id)
                                     ->where('status', 'sold')
                                     ->count(),
            'low_stock' => Product::where($foreignKey, $farmer->id)
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
            'total_revenue' => Order::where('seller_id', $farmer->id)
                                   ->where('status', 'completed')
                                   ->sum('total_amount'),
            'pending_advice' => AdviceRequest::where('farmer_id', $farmer->id)
                                            ->where('status', 'pending')
                                            ->count(),
        ];
        
        // Get recent products
        $recentProducts = Product::where($foreignKey, $farmer->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        
        // Get recent orders
        $recentOrders = Order::where('buyer_id', $farmer->id)
                            ->with('seller')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
        
        // No weather data - removed completely
        return view('farmer.dashboard', compact('stats', 'recentProducts', 'recentOrders'));
    }
}