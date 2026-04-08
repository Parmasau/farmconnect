<?php
// app/Http/Controllers/Agrovet/AnalyticsController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Consultation;
use App\Models\AdviceRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $agrovet = Auth::user();
        
        // Sales Analytics
        $totalSales = Order::where('seller_id', $agrovet->id)
                          ->where('status', 'completed')
                          ->sum('total_amount');
        
        $totalOrders = Order::where('seller_id', $agrovet->id)->count();
        $completedOrders = Order::where('seller_id', $agrovet->id)
                               ->where('status', 'completed')
                               ->count();
        $pendingOrders = Order::where('seller_id', $agrovet->id)
                             ->where('status', 'pending')
                             ->count();
        $cancelledOrders = Order::where('seller_id', $agrovet->id)
                               ->where('status', 'cancelled')
                               ->count();
        
        $averageOrderValue = $completedOrders > 0 ? $totalSales / $completedOrders : 0;
        
        // Monthly Sales for Chart
        $monthlySales = Order::where('seller_id', $agrovet->id)
                            ->where('status', 'completed')
                            ->select(
                                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                                DB::raw('SUM(total_amount) as total')
                            )
                            ->where('created_at', '>=', now()->subMonths(12))
                            ->groupBy('month')
                            ->orderBy('month', 'asc')
                            ->get();
        
        // Product Analytics
        $totalProducts = Product::where('user_id', $agrovet->id)->count();
        $activeProducts = Product::where('user_id', $agrovet->id)
                                ->where('status', 'active')
                                ->where('quantity', '>', 0)
                                ->count();
        $lowStockProducts = Product::where('user_id', $agrovet->id)
                                  ->where('quantity', '<', 10)
                                  ->where('quantity', '>', 0)
                                  ->count();
        $outOfStockProducts = Product::where('user_id', $agrovet->id)
                                    ->where('quantity', 0)
                                    ->count();
        
        // Top Selling Products
        $topProducts = Product::where('user_id', $agrovet->id)
                             ->withCount(['orderItems as total_sold' => function($query) {
                                 $query->select(DB::raw('SUM(quantity)'));
                             }])
                             ->orderBy('total_sold', 'desc')
                             ->limit(5)
                             ->get();
        
        // Consultation Analytics - Real-time
        $totalConsultations = Consultation::where('agrovet_id', $agrovet->id)->count();
        $pendingConsultations = Consultation::where('agrovet_id', $agrovet->id)
                                           ->where('status', 'requested')
                                           ->count();
        $confirmedConsultations = Consultation::where('agrovet_id', $agrovet->id)
                                             ->where('status', 'confirmed')
                                             ->count();
        $inProgressConsultations = Consultation::where('agrovet_id', $agrovet->id)
                                              ->where('status', 'in_progress')
                                              ->count();
        $completedConsultations = Consultation::where('agrovet_id', $agrovet->id)
                                             ->where('status', 'completed')
                                             ->count();
        $cancelledConsultations = Consultation::where('agrovet_id', $agrovet->id)
                                             ->where('status', 'cancelled')
                                             ->count();
        
        // Advice Analytics - Real-time
        $totalAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)->count();
        $pendingAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                     ->where('status', 'pending')
                                     ->count();
        $assignedAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                      ->where('status', 'assigned')
                                      ->count();
        $answeredAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                      ->where('status', 'answered')
                                      ->count();
        $resolvedAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                      ->where('status', 'resolved')
                                      ->count();
        
        // Message Analytics - Real-time
        $totalMessagesReceived = Message::where('receiver_id', $agrovet->id)->count();
        $unreadMessages = Message::where('receiver_id', $agrovet->id)
                                ->whereNull('read_at')
                                ->count();
        $totalMessagesSent = Message::where('sender_id', $agrovet->id)->count();
        
        // Response Rate (Advice)
        $responseRate = $totalAdvice > 0 ? round(($answeredAdvice / $totalAdvice) * 100, 2) : 0;
        
        // Consultation Acceptance Rate
        $acceptanceRate = $totalConsultations > 0 ? round((($confirmedConsultations + $inProgressConsultations + $completedConsultations) / $totalConsultations) * 100, 2) : 0;
        
        // Category Performance
        $categoryPerformance = Product::where('user_id', $agrovet->id)
                                     ->select('category', DB::raw('COUNT(*) as count'))
                                     ->groupBy('category')
                                     ->get();
        
        return view('agrovet.analytics.index', compact(
            'totalSales', 'totalOrders', 'completedOrders', 'pendingOrders', 'cancelledOrders', 'averageOrderValue',
            'monthlySales', 'totalProducts', 'activeProducts', 'lowStockProducts', 'outOfStockProducts',
            'topProducts', 'totalConsultations', 'pendingConsultations', 'confirmedConsultations',
            'inProgressConsultations', 'completedConsultations', 'cancelledConsultations',
            'totalAdvice', 'pendingAdvice', 'assignedAdvice', 'answeredAdvice', 'resolvedAdvice',
            'totalMessagesReceived', 'unreadMessages', 'totalMessagesSent', 'responseRate', 'acceptanceRate',
            'categoryPerformance'
        ));
    }
}