<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $farmer = Auth::user();
        
        $totalProducts = Product::where('farmer_id', $farmer->id)->count();
        $totalOrders = Order::where('buyer_id', $farmer->id)->count();
        $totalRevenue = Order::where('seller_id', $farmer->id)
                            ->where('status', 'completed')
                            ->sum('total_amount');
        
        $monthlySales = Order::where('seller_id', $farmer->id)
                            ->where('status', 'completed')
                            ->select(
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('SUM(total_amount) as total')
                            )
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->orderBy('month', 'desc')
                            ->limit(6)
                            ->get();
        
        return view('farmer.analytics.index', compact('totalProducts', 'totalOrders', 'totalRevenue', 'monthlySales'));
    }

    public function sales()
    {
        $farmer = Auth::user();
        
        $sales = Order::where('seller_id', $farmer->id)
                     ->with('buyer')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);
        
        return view('farmer.analytics.sales', compact('sales'));
    }

    public function products()
    {
        $farmer = Auth::user();
        
        $products = Product::where('farmer_id', $farmer->id)
                          ->withCount('orderItems')
                          ->orderBy('order_items_count', 'desc')
                          ->paginate(15);
        
        return view('farmer.analytics.products', compact('products'));
    }
}