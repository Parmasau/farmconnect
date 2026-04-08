<?php
// app/Http/Controllers/Agrovet/DashboardController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\AdviceRequest;
use App\Models\Consultation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $agrovet = Auth::user();
        
        // Product Statistics
        $stats = [
            'products' => Product::where('user_id', $agrovet->id)->count(),
            'available_products' => Product::where('user_id', $agrovet->id)
                                         ->where('status', 'active')
                                         ->where('quantity', '>', 0)
                                         ->count(),
            'low_stock' => Product::where('user_id', $agrovet->id)
                                 ->where('quantity', '<', 10)
                                 ->where('quantity', '>', 0)
                                 ->count(),
            'out_of_stock' => Product::where('user_id', $agrovet->id)
                                     ->where('quantity', 0)
                                     ->count(),
        ];
        
        // Order Statistics
        $stats['orders'] = Order::where('seller_id', $agrovet->id)->count();
        $stats['pending_orders'] = Order::where('seller_id', $agrovet->id)
                                       ->where('status', 'pending')
                                       ->count();
        $stats['processing_orders'] = Order::where('seller_id', $agrovet->id)
                                          ->where('status', 'processing')
                                          ->count();
        $stats['completed_orders'] = Order::where('seller_id', $agrovet->id)
                                         ->where('status', 'completed')
                                         ->count();
        $stats['total_revenue'] = Order::where('seller_id', $agrovet->id)
                                      ->where('status', 'completed')
                                      ->sum('total_amount');
        
        // Advice Statistics - Real-time
        $stats['advice'] = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                        ->where('status', 'pending')
                                        ->count();
        $stats['total_advice'] = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)->count();
        $stats['answered_advice'] = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                                ->where('status', 'answered')
                                                ->count();
        
        // Consultation Statistics - Real-time
        $stats['consultations'] = Consultation::where('agrovet_id', $agrovet->id)
                                             ->where('status', 'requested')
                                             ->count();
        $stats['total_consultations'] = Consultation::where('agrovet_id', $agrovet->id)->count();
        $stats['confirmed_consultations'] = Consultation::where('agrovet_id', $agrovet->id)
                                                       ->where('status', 'confirmed')
                                                       ->count();
        $stats['in_progress_consultations'] = Consultation::where('agrovet_id', $agrovet->id)
                                                         ->where('status', 'in_progress')
                                                         ->count();
        $stats['completed_consultations'] = Consultation::where('agrovet_id', $agrovet->id)
                                                       ->where('status', 'completed')
                                                       ->count();
        
        // Message Statistics - Real-time
        $stats['total_messages'] = Message::where('receiver_id', $agrovet->id)->count();
        $stats['unread_messages'] = Message::where('receiver_id', $agrovet->id)
                                          ->whereNull('read_at')
                                          ->count();
        $stats['sent_messages'] = Message::where('sender_id', $agrovet->id)->count();
        
        // Recent Orders (Last 5)
        $recentOrders = Order::where('seller_id', $agrovet->id)
                            ->with('buyer')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
        
        // Pending Advice (Last 5)
        $pendingAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                     ->where('status', 'pending')
                                     ->with('farmer')
                                     ->orderBy('created_at', 'desc')
                                     ->limit(5)
                                     ->get();
        
        // Recent Consultations (Last 5)
        $recentConsultations = Consultation::where('agrovet_id', $agrovet->id)
                                          ->with('farmer')
                                          ->orderBy('created_at', 'desc')
                                          ->limit(5)
                                          ->get();
        
        // Recent Products (Last 5)
        $recentProducts = Product::where('user_id', $agrovet->id)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        
        // Recent Messages (Last 5)
        $recentMessages = Message::where('receiver_id', $agrovet->id)
                                ->orWhere('sender_id', $agrovet->id)
                                ->with(['sender', 'receiver'])
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        
        // Monthly Sales Data for Chart
        $monthlySales = Order::where('seller_id', $agrovet->id)
                            ->where('status', 'completed')
                            ->select(
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('SUM(total_amount) as total')
                            )
                            ->where('created_at', '>=', now()->subMonths(6))
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'asc')
                            ->orderBy('month', 'asc')
                            ->get();
        
        return view('agrovet.dashboard', compact(
            'stats', 
            'recentOrders', 
            'pendingAdvice', 
            'recentConsultations',
            'recentProducts', 
            'recentMessages',
            'monthlySales'
        ));
    }
}