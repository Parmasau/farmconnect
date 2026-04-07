<?php
// app/Http/Controllers/Agrovet/DashboardController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\AdviceRequest;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $agrovet = Auth::user();
        
        $stats = [
            'products' => Product::where('user_id', $agrovet->id)->count(),
            'orders' => Order::where('seller_id', $agrovet->id)->count(),
            'advice' => 0,
            'consultations' => 0,
        ];
        
        // Only query advice if column exists
        if (Schema::hasColumn('advice_requests', 'assigned_agrovet_id')) {
            $stats['advice'] = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                           ->where('status', 'pending')
                                           ->count();
        }
        
        // Only query consultations if table exists
        if (Schema::hasTable('consultations')) {
            $stats['consultations'] = Consultation::where('agrovet_id', $agrovet->id)
                                                ->where('status', 'pending')
                                                ->count();
        }
        
        $recentOrders = Order::where('seller_id', $agrovet->id)
                            ->with('buyer')
                            ->latest()
                            ->limit(5)
                            ->get();
        
        $pendingAdvice = collect([]);
        if (Schema::hasColumn('advice_requests', 'assigned_agrovet_id')) {
            $pendingAdvice = AdviceRequest::where('assigned_agrovet_id', $agrovet->id)
                                         ->where('status', 'pending')
                                         ->with('farmer')
                                         ->latest()
                                         ->limit(5)
                                         ->get();
        }
        
        return view('agrovet.dashboard', compact('stats', 'recentOrders', 'pendingAdvice'));
    }
}