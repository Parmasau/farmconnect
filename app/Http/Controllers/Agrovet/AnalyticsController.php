<?php
// app/Http/Controllers/Agrovet/AnalyticsController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Consultation;
use App\Models\AdviceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $agrovet = Auth::user();
        
        // Order Statistics
        $totalOrders = Order::where('seller_id', $agrovet->id)->count();
        $pendingOrders = Order::where('seller_id', $agrovet->id)->where('status', 'pending')->count();
        $processingOrders = Order::where('seller_id', $agrovet->id)->where('status', 'processing')->count();
        $completedOrders = Order::where('seller_id', $agrovet->id)->where('status', 'completed')->count();
        $totalRevenue = Order::where('seller_id', $agrovet->id)->where('status', 'completed')->sum('total_amount');
        
        // Product Statistics
        $totalProducts = Product::where('user_id', $agrovet->id)->count();
        $lowStockProducts = Product::where('user_id', $agrovet->id)->where('quantity', '<', 10)->count();
        $outOfStockProducts = Product::where('user_id', $agrovet->id)->where('quantity', 0)->count();
        
        // Consultation Statistics
        $totalConsultations = Consultation::where('agrovet_id', $agrovet->id)->count();
        $pendingConsultations = Consultation::where('agrovet_id', $agrovet->id)->where('status', 'pending')->count();
        $completedConsultations = Consultation::where('agrovet_id', $agrovet->id)->where('status', 'completed')->count();
        
        // Advice Statistics
        $totalAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)->count();
        $pendingAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)->where('status', 'pending')->count();
        $answeredAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)->where('status', 'answered')->count();
        
        // Monthly Sales Chart Data
        $monthlySales = Order::where('seller_id', $agrovet->id)
                            ->where('status', 'completed')
                            ->select(
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('SUM(total_amount) as total')
                            )
                            ->where('created_at', '>=', now()->subMonths(6))
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->orderBy('month', 'desc')
                            ->get();
        
        // Top Selling Products
        $topProducts = Product::where('user_id', $agrovet->id)
                             ->withCount(['orderItems as total_sold' => function($query) {
                                 $query->select(DB::raw('SUM(quantity)'));
                             }])
                             ->orderBy('total_sold', 'desc')
                             ->limit(5)
                             ->get();
        
        return view('agrovet.analytics.index', compact(
            'totalOrders', 'pendingOrders', 'processingOrders', 'completedOrders', 'totalRevenue',
            'totalProducts', 'lowStockProducts', 'outOfStockProducts',
            'totalConsultations', 'pendingConsultations', 'completedConsultations',
            'totalAdvice', 'pendingAdvice', 'answeredAdvice',
            'monthlySales', 'topProducts'
        ));
    }
}